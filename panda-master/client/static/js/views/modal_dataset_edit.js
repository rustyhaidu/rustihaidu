PANDA.views.DatasetEdit = Backbone.View.extend({
    events: {
        "click #dataset-edit-save":   "edit_save"
    },

    dataset: null,

    text: PANDA.text.DatasetEdit(),

    initialize: function(options) {
        _.bindAll(this);
    },

    reset: function(dataset) {
        this.dataset = dataset;
    },

    render: function() {
        var all_categories = _.reject(Redd.get_categories().toJSON(), function(c) {
            return (c.id == PANDA.settings.UNCATEGORIZED_ID);
        });

        var context = PANDA.utils.make_context({
            text: this.text,
            dataset: this.dataset.toJSON(true),
            categories: this.dataset.categories.toJSON(),
            all_categories: all_categories 
        });

        this.$el.html(PANDA.templates.modal_dataset_edit(context));

        $("#edit-dataset-form").keypress(_.bind(function(e) {
            if (e.keyCode == 13 && e.target.type != "textarea") {
                this.edit_save(); 
                return false;
            }
        }, this));
    },

    validate: function() {
        /*
         * Validate metadata for save.
         */
        var data = $("#edit-dataset-form").serializeObject();
        var errors = {};

        if (!data["name"]) {
            errors["name"] = [gettext("This field is required.")];
        }

        return errors;
    },

    edit_save: function() {
        /*
         * Save metadata edited via modal.
         */
        var errors = this.validate();
        
        if (!_.isEmpty(errors)) {
            $("#edit-dataset-form").show_errors(errors, gettext("Save failed!"));
        
            return false;
        }
        
        var form_values = $("#edit-dataset-form").serializeObject();

        var s = {};

        // Ensure categories is cleared
        if (!("categories" in form_values)) {
            this.dataset.categories.reset();
        }

        _.each(form_values, _.bind(function(v, k) {
            if (k == "categories") {
                // If only a single category is selected it will serialize as a string instead of a list
                if (!_.isArray(v)) {
                    v = [v];
                }

                categories = _.map(v, function(cat) {
                    return Redd.get_category_by_slug(cat).clone();
                });

                this.dataset.categories.reset(categories);
            } else {
                s[k] = escape(v);
            }
        }, this));

        this.dataset.patch(s, 
           function(dataset) {
                $("#modal-edit-dataset").modal("hide");
                Redd.goto_dataset_view(dataset.get("slug"));
                Redd.refresh_categories();
            },
            function(dataset, response) {
                try {
                    errors = $.parseJSON(response);
                } catch(e) {
                    errors = { "__all__": gettext("Unknown error") }; 
                }

                $("#edit-dataset-form").show_errors(errors, gettext("Save failed!"));
            }
        );

        return false;
    }
})

