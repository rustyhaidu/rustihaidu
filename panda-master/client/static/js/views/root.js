PANDA.views.Root = Backbone.View.extend({
    /*
     * The singleton view which manages all others. Essentially, a "controller".
     *
     * A single instance of this object exists in the global namespace as "Redd".
     */
    el: "body",

    events: {
        "click #navbar-notifications > a":   "clear_unread_notifications"
    },

    views: {},

    _router: null,
    _current_user: null,
    _categories: null,

    notifications_refresh_timer_id: null,

    current_content_view: null,

    initialize: function() {
        // Bind local methods
        _.bindAll(this);

        // Track Ajax events
        this.track_ajax_events();

        // Handle CSRF cookies for POST data
        this.configure_csrf_handling();

        // Override Backbone's sync handler with the authenticated version
        Backbone.noAuthSync = Backbone.sync;
        Backbone.sync = _.bind(this.sync, this);

        // Create objects from bootstrap data
        this._categories = new PANDA.collections.Categories(PANDA.bootstrap.categories);

        // Setup global router
        this._router = new PANDA.routers.Index({ controller: this });

        // Configure the global navbar
        this.configure_navbar();

        // Setup occasional updates of notifications
        this.notifications_refresh_timer_id = window.setInterval(this.refresh_notifications, PANDA.settings.NOTIFICATIONS_INTERVAL);

        return this;
    },

    track_ajax_events: function() {
        $(document).ajaxStart(function() {
            $("#loading-indicator img").show();
        });

        $(document).ajaxStop(function() {
            $("#loading-indicator img").hide();
        });
    },

    configure_csrf_handling: function() {
        /*
         * Always attach CSRF token to requests.
         */
        $.ajaxSetup({ 
             beforeSend: function(xhr, settings) {
                xhr.setRequestHeader("X-CSRFToken", $.cookie('csrftoken'));
             } 
        });
    },

    start_routing: function() {
        /*
         * Start Backbone routing. Separated from initialize() so that the
         * global controller is available for any preset routes (direct links).
         */
        Backbone.history.start();
    },

    authenticate: function() {
        /*
         * Verifies that the current user is authenticated, first by checking
         * for an active user and then by checking for a cookie. Redirects
         * to login if authentication fails.
         */
        if (this._current_user) {
            return true;
        }

        var id = $.cookie("id");
        var email = $.cookie("email");
        var is_staff = $.cookie("is_staff") === "true" ? true : false;

        if (email) {
            this.set_current_user(new PANDA.models.User({
                "id": id,
                "email": email,
                "is_staff": is_staff
            }));

            // Fetch latest notifications (doubles as a verification of the user's credentials)
            this.refresh_notifications(); 

            return true;
        }

        this.goto_login(window.location.hash);

        return false;
    },

    get_current_user: function() {
        /*
         * Gets the current system user.
         */
        return this._current_user;
    },

    set_current_user: function(user) {
        /*
         * Sets the current system user. Assumes that user has already authenticated.
         */
        this._current_user = user;

        if (this._current_user) {
            $.cookie("id", this._current_user.get("id"), { expires: 30 });
            $.cookie("email", this._current_user.get("email"), { expires: 30 });
            $.cookie("is_staff", this._current_user.get("is_staff").toString(), { expires: 30 });
        } else {
            $.cookie("id", null);
            $.cookie("email", null);
            $.cookie("is_staff", null);
            $.cookie("activity_recorded", null)
        }
            
        this.configure_navbar();
    },

    get_categories: function() {
        /*
         * Retrieve global list of categories that was bootstrapped onto the page.
         */
        return this._categories;
    },

    get_category_by_slug: function(slug) {
        /*
         * Retrieve a specific category by slug.
         */
        return this._categories.find(function(cat) { return cat.get("slug") == slug; });
    },

    ajax: function(options) {
        /*
         * Makes an authenticated ajax request to the API.
         */
        var dfd = new $.Deferred();

        this.authenticate();

        // Handle authentication failures
        dfd.fail(_.bind(function(responseXhr, status, error) {
            if (responseXhr.status == 401) {
                this.set_current_user(null);
                this.goto_login(window.location.hash);
            }
        }, this));

        // Trigger original error handler after checking for auth issues
        dfd.fail(options.error);
        options.error = dfd.reject;

        dfd.request = $.ajax(options);

        return dfd;
    },

    sync: function(method, model, options) {
        /*
         * Custom Backbone sync handler to attach authorization headers
         * and handle failures.
         */
        var dfd = new $.Deferred();

        this.authenticate();

        // Handle authentication failures
        dfd.fail(_.bind(function(xhr, status, error) {
            if (xhr.status == 401) {
                this.set_current_user(null);
                this.goto_login(window.location.hash);
            }
        }, this));

        // Trigger original error handler after checking for auth issues
        dfd.fail(options.error);
        options.error = dfd.reject;

        dfd.request = Backbone.noAuthSync(method, model, options);

        return dfd;
    },

    log_user_activity: function() {
        /*
         * Record that the user was on-site.
         */
        if (!this._current_user) {
            return;
        }

        var activity_recorded = $.cookie("activity_recorded") === "true" ? true : false;

        if (!activity_recorded) {
            activity_log = new PANDA.models.ActivityLog();
            activity_log.save();

            var today = new Date();
            var midnight = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1, 0, 0, 0);

            $.cookie("activity_recorded", "true", { expires: midnight });
        }
    },

    configure_navbar: function(no_scroll) {
        /*
         * Reconfigures the Bootstrap navbar based on the current user.
         */
        if (!this._current_user) {
            $(".navbar").hide();
            $("body").css("background-color", "#404040");
        } else {
            $("body").css("background-color", "#fff");

            $("#navbar-email a").text(this._current_user.get("email"));
            $("#navbar-email a").attr("href", "#user/" + this._current_user.get("id"));

            // Categories
            $("#navbar-categories .dropdown-menu").empty();
            $("#navbar-categories .dropdown-menu").append('<li><a href="#datasets/all">' + gettext("All datasets") + '</a></li>');

            if (this._categories.length > 0) {
                $("#navbar-categories .dropdown-menu").append('<li class="divider"></li>');
                
                this._categories.each(function(category) {
                    if (category.get("dataset_count") > 0) {
                        $("#navbar-categories .dropdown-menu").append('<li class="category"><a href="#datasets/' + category.get("slug") + '">' + category.get("name") + ' (' + category.get("dataset_count") + ')</a></li>');
                    }
                });
            }

            // Notifications
            $("#navbar-notifications .dropdown-menu ul").empty();

            var unread_count = 0;

            if (this._current_user.notifications.length > 0) {

                this._current_user.notifications.each(function(note) {
                    var unread = note.get("read_at") ? "" : " unread"

                    if (unread) { 
                        unread_count += 1
                    };

                    $("#navbar-notifications .dropdown-menu ul").append('<li class="' + unread + '"><a href="' + note.get("url") + '" data-notification-id="' + note.id + '">' + unescape(note.get("message")) + '</a></li>');
                }, this);
            } else {
                $("#navbar-notifications .dropdown-menu ul").append('<li><a href="#"><em>' + gettext("No notifications") + '</em></a></li>');
            }

            if (unread_count) {
                $("#navbar-notifications .count").addClass("badge-info");
            } else {
                $("#navbar-notifications .count").removeClass("badge-info");
            }
            
            $("#navbar-notifications .count").text(unread_count);

            $("#navbar-admin").toggle(this._current_user.get("is_staff"));
            $(".navbar").show();
        }
    },

    refresh_categories: function() {
        this._categories.fetch({ success: _.bind(function() {
            this.configure_navbar();
        }, this) });
    },

    refresh_notifications: function() {
        if (this._current_user) {
            this._current_user.refresh_notifications(_.bind(function() {
                this.configure_navbar();
                this.log_user_activity();
            }, this));
        }
    },

    clear_unread_notifications: function() {
        /*
         * Marks all of the current user's notifications as read.
         */
        if ($("#navbar-notifications").hasClass("open")) {
            $("#navbar-notifications .count").removeClass("badge-info");
            $("#navbar-notifications .count").text("0");

            this._current_user.mark_notifications_read();
        } else {
            $("#navbar-notifications .dropdown-menu ul li").removeClass("unread");
        }

        return true;
    },

    get_or_create_view: function(name) {
        /*
         * Register each view as it is created and never create more than one.
         */
        // Clear detritus from previous views
        $(".tooltip").remove();
        $(".modal").remove()
        $(".modal-backdrop").remove()
        
        window.scrollTo(0, 0);

        if (name in this.views) {
            return this.views[name];
        }

        this.views[name] = new PANDA.views[name]({ el: PANDA.settings.CONTENT_ELEMENT });

        return this.views[name];
    },

    goto_activate: function(activation_key) {
        this.current_content_view = this.get_or_create_view("Activate");
        this.current_content_view.reset(activation_key);

        this._router.navigate("activate/" + activation_key);
    },

        goto_reset_password: function(activation_key) {
        this.current_content_view = this.get_or_create_view("ResetPassword");
        this.current_content_view.reset(activation_key);

        this._router.navigate("reset-password/" + activation_key);
    },

    goto_login: function(next) {
        this.current_content_view = this.get_or_create_view("Login");
        this.current_content_view.reset(next);

        this._router.navigate("login");
    },
    
    goto_logout: function() {
        // Request a session logout
        $.ajax({
            url: '/logout/',
            type: 'POST'
        });

        // Blow away local cookies
        this.set_current_user(null);

        // Back to the login screen
        this.goto_login();
    },

    goto_search: function(category, query, since, limit, page) {
        // This little trick avoids rerendering the Search view if
        // its already visible. Only the nested results need to be
        // rerendered.
        if (!this.authenticate()) {
            return;
        }

        if (!(this.current_content_view instanceof PANDA.views.Search)) {
            this.current_content_view = this.get_or_create_view("Search");
            this.current_content_view.reset(category, query);
        }

        category = category || "all";

        this.current_content_view.search(category, query, since, limit, page);

        var path = "search/" + category;

        if (query) {
            path += "/" + query;

            if (since) {
                path += "/" + since;

                if (limit) {
                    path += "/" + limit;

                    if (page) {
                        path += "/" + page;
                    }
                }
            }
        }

        this._router.navigate(path);
    },

    goto_data_upload: function(dataset_slug) {
        if (!this.authenticate()) {
            return;
        }

        this.current_content_view = this.get_or_create_view("DataUpload");
        this.current_content_view.reset(dataset_slug);

        if (dataset_slug) {
            this._router.navigate("dataset/" + dataset_slug + "/upload");
        } else {
            this._router.navigate("upload");
        }
    },

    goto_datasets_search: function(category, query, limit, page) {
        if (!this.authenticate()) {
            return;
        }

        this.current_content_view = this.get_or_create_view("DatasetsSearch");
        this.current_content_view.reset(category, query, limit, page);

        var path = "datasets/" + category;

        if (query) {
            path += "/" + query;

            if (limit) {
                path += "/" + limit;

                if (page) {
                    path += "/" + page;
                }
            }
        }

        this._router.navigate(path);
    },

    goto_dataset_view: function(slug) {
        if (!this.authenticate()) {
            return;
        }

        this.current_content_view = this.get_or_create_view("DatasetSearch");
        this.current_content_view.reset(slug, null);

        this._router.navigate("dataset/" + slug);
    },

    goto_dataset_search: function(slug, query, since, limit, page) {
        if (!this.authenticate()) {
            return;
        }

        if (!(this.current_content_view instanceof PANDA.views.DatasetSearch)) {
            this.current_content_view = this.get_or_create_view("DatasetSearch");
            this.current_content_view.reset(slug, query);
        }

        this.current_content_view.search(query, since, limit, page);

        var path = "dataset/" + slug + "/search";

        if (query) {
            path += "/" + query;

            if (since) {
                path += "/" + since;

                if (limit) {
                    path += "/" + limit;

                    if (page) {
                        path += "/" + page;
                    }
                }
            }
        }

        this._router.navigate(path);
    },

    goto_notifications: function(limit, page) {
        if (!this.authenticate()) {
            return;
        }

        this.current_content_view = this.get_or_create_view("Notifications");
        this.current_content_view.reset(limit, page);

        var path = "notifications";

        if (limit) {
            path += "/" + limit;

            if (page) {
                path += "/" + page;
            }
        }

        this._router.navigate(path);
    },

    goto_user: function(id) {
        if (!this.authenticate()) {
            return;
        }

        this.current_content_view = this.get_or_create_view("User");
        this.current_content_view.reset(id);

        this._router.navigate("user/" + id);
    },

    goto_dashboard: function() {
        if (!this.authenticate()) {
            return;
        }

        this.current_content_view = this.get_or_create_view("Dashboard");
        this.current_content_view.reset();

        this._router.navigate("dashboard");
    },

    goto_fetch_export: function(id) {
        if (!this.authenticate()) {
            return;
        }
        
        this.current_content_view = this.get_or_create_view("FetchExport");
        this.current_content_view.reset(id);

        this._router.navigate("export/" + id);
    },

    goto_not_found: function() {
        if (!(this.current_content_view instanceof PANDA.views.NotFound)) {
            this.current_content_view = this.get_or_create_view("NotFound");
        }

        this.current_content_view.reset();
    },

    goto_server_error: function() {
        if (!(this.current_content_view instanceof PANDA.views.ServerError)) {
            this.current_content_view = this.get_or_create_view("ServerError");
        }

        this.current_content_view.reset();
    }
});
