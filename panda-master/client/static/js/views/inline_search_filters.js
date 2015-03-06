PANDA.views.DatasetSearchFilters = Backbone.View.extend({
    operations: {
        "unicode": {
            "is_like": {
                "name": gettext("is like"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_unicode"
            }
        },
        "int": {
            "is": {
                "name": gettext("is"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_ints"
            },
            "is_greater": {
                "name": gettext("is greater than or equal to"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_ints"
            },
            "is_less": {
                "name":gettext( "is less than or equal to"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_ints"
            },
            "is_range": {
                "name": gettext("is in the range"),
                "widget_template": "inline_widget_double_input",
                "parser": "parse_inline_widget_double_input",
                "validator": "validate_ints"
            }
        },
        "float": {
            "is": {
                "name": gettext("is"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_floats"
            },
            "is_greater": {
                "name": gettext("is greater than or equal to"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_floats"
            },
            "is_less": {
                "name": gettext("is less than or equal to"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_floats"
            },
            "is_range": {
                "name": gettext("is in the range"),
                "widget_template": "inline_widget_double_input",
                "parser": "parse_inline_widget_double_input",
                "validator": "validate_floats"
            }
        },
        "bool": {
            "is": {
                "name": gettext("is"),
                "widget_template": "inline_widget_bool_selector",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_dummy"
            }
        },
        "datetime": {
            "is": {
                "name": gettext("is"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_datetimes"
            },
            "is_greater": {
                "name": gettext("is on or after"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_datetimes"
            },
            "is_less": {
                "name": gettext("is on or before"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_datetimes"
            },
            "is_range": {
                "name": gettext("is in the range"),
                "widget_template": "inline_widget_double_input",
                "parser": "parse_inline_widget_double_input",
                "validator": "validate_datetimes"
            }
        },
        "date": {
            "is": {
                "name": gettext("is"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_dates"
            },
            "is_greater": {
                "name": gettext("is on or after"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_dates"
            },
            "is_less": {
                "name": gettext("is on or before"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_dates"
            },
            "is_range": {
                "name": gettext("is in the range"),
                "widget_template": "inline_widget_double_input",
                "parser": "parse_inline_widget_double_input",
                "validator": "validate_dates"
            }
        },
        "time": {
            "is": {
                "name": gettext("is"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_times"
            },
            "is_greater": {
                "name": gettext("is at or after"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_times"
            },
            "is_less": {
                "name": gettext("is at or before"),
                "widget_template": "inline_widget_single_input",
                "parser": "parse_inline_widget_single_input",
                "validator": "validate_times"
            },
            "is_range": {
                "name": gettext("is in the range"),
                "widget_template": "inline_widget_double_input",
                "parser": "parse_inline_widget_double_input",
                "validator": "validate_times"
            }
        }
    },

    events: {
        "click .remove-filter":   "remove_filter"
    },

    search: null,

    text: PANDA.text.DatasetSearchFilters(),

    initialize: function(options) {
        _.bindAll(this);
    },

    reset: function(search) {
        this.search = search;
    },

    render: function() {
        var context = PANDA.utils.make_context({
            "text": this.text,
            "dataset": this.search.dataset.results(),
            "render_filter": this.render_filter,
            "column_is_filterable": this.column_is_filterable,
            "column_has_query": this.column_has_query,
            "has_any_filters": _.any(this.search.dataset.get("column_schema"), this.column_is_filterable)
        });

        $("#dataset-search-filters").html(PANDA.templates.inline_search_filters(context));

        var filters_are_on = false;

        _.each(this.search.dataset.get("column_schema"), _.bind(function(c, i) {
            if (this.column_is_filterable(c) && this.column_has_query(c)) {
                $("#filter-" + i).show();
                filters_are_on = true;
            }
        }, this));

        // If any filters are turned on make sure the fields are visible
        if (filters_are_on) {
            $(".search-help").show();
            $("#dataset-search-filters").show();
            $("#toggle-advanced-search").text(gettext("Fewer search options"));
        }

        $("#add-filter").change(this.add_filter);
        $(".operator").change(this.change_operator);
    },

    column_is_filterable: function(c) {
        /*
         * Determine if a column is filterable.
         */
        return c["indexed"] && c["type"];
    },

    column_has_query: function(c) {
        /*
         * Determine if a column has a current value.
         */
        return this.search.query && this.search.query[c["name"]];
    },

    render_filter: function(c, i) {
        /*
         * Render a single column filter to a string.
         */
        var query = this.get_column_query(c);
        var operation = this.get_column_operation(c, query);
        var operations = this.get_column_operations(c);
        var widget_template = this.get_column_widget_template(operation);

        filter_context = PANDA.utils.make_context({
            "text": this.text,
            "i": i,
            "column": c,
            "query": query,
            "operation": operation,
            "operations": operations,
            "widget_template": widget_template,
            "format_min_max": this.format_min_max
        });
        
        return PANDA.templates.inline_search_filter(filter_context);    
    },

    format_min_max: function(c, min_or_max) {
        /*
         * Convert min/max values from a column to a format suitable for display.
         */
        var v = c[min_or_max];

        if (c["type"] == "datetime") {
            return moment(v, "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD HH:mm")
        } else if (c["type"] == "date") {
            return moment(v, "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD")
        } else if (c["type"] == "time") {
            return moment(v, "YYYY-MM-DD HH:mm:ss").format("HH:mm")
        } else {
            return v;
        }
    },

    get_column_query: function(c) {
        /*
         * Fetch a column's query or return a default query data structure.
         */
        if (this.column_has_query(c)) {
            return this.search.query[c["name"]];
        } else {
            var op = "is";

            if (c["type"] == "unicode") {
                op = "is_like";
            }

            return { "operator": op, "value": "", "range_value": "" };
        }
    },

    get_column_operation: function(c, q) {
        /*
         * Fetch an operation object based a column's type and currently
         * selected operation.
         */
        return this.operations[c["type"]][q["operator"]];
    },

    get_column_operations: function(c) {
        /*
         * Get a list of all possible operations for a given column's type.
         */
        return this.operations[c["type"]];
    },

    get_column_widget_template: function(column_operation) {
        /*
         * Get an appropriate widget template based on a column's operation.
         */
        return PANDA.templates[column_operation["widget_template"]]
    },

    add_filter: function() {
        /*
         * Add a column filter.
         */
        var i = $("#add-filter").val();
        var filter = $("#filter-" + i);

        if (filter.is(":hidden")) {
            var c = this.search.dataset.get("column_schema")[i];

            filter.html(this.render_filter(c, i));
            filter.show();

            filter.find(".operator").change(this.change_operator);
        }
        
        $("#add-filter").val("");
    },

    change_operator: function(e) {
        /*
         * When the selected operation is changed, update to use the new widget.
         */
        var last_op = $(e.currentTarget).data("last-value");
        var new_op = $(e.currentTarget).val();

        var filter = $(e.currentTarget).parents(".filter");
        var filter_id = filter.data("filter-id");
        var c = this.search.dataset.get("column_schema")[filter_id];

        var column_query = this.get_column_query(c); 
        var last_operation = this.get_column_operation(c, column_query);
        column_query["operator"] = new_op;
        var column_operation = this.get_column_operation(c, column_query);

        // Parse values before swapping widgets, so they will be carried over
        var values = this[last_operation["parser"]](filter);
        $.extend(column_query, values);

        filter.find(".widget").html(this.get_column_widget_template(column_operation)(column_query));

        $(e.currentTarget).data("last-value", new_op);
    },

    remove_filter: function(e) {
        /*
         * Remove a column filter.
         */
        $(e.currentTarget).parents(".filter").hide();
        $(e.currentTarget).parents(".filter").empty();
    },

    encode: function() {
        /*
         * Encode selected filters into query string format.
         */
        var terms = [];
        var errors = {};

        _.each(this.search.dataset.get("column_schema"), _.bind(function(c, i) {
            // Skip unfilterable columns
            if (!this.column_is_filterable(c)) {
                return;
            }

            var filter = $("#filter-" + i);

            // Skip unused filters
            if (filter.is(":hidden")) {
                return;
            }

            var operator = filter.find(".operator").val();
            var parser = this.operations[c["type"]][operator]["parser"];
            var validator = this.operations[c["type"]][operator]["validator"];
            var values = this[parser](filter);

            if (!values["value"]) {
                return;
            }

            try {
                this[validator](c, values);
            } catch (e) {
                errors[i] = e.message;
                return;
            }

            terms.push(c["name"] + ":::" + operator + ":::" + values["value"] + ":::" + values["range_value"]);
        }, this));

    
        if (!_.isEmpty(errors)) {
            throw new PANDA.errors.FilterValidationError(errors); 
        }

        return terms.join("|||");
    },

    /* Value parsers - extract values from widgets */

    parse_inline_widget_single_input: function(filter) {
        return { "value": filter.find(".value").val(), "range_value": "" };
    },
    
    parse_inline_widget_double_input: function(filter) {
        return { "value": filter.find(".value").val(), "range_value": filter.find(".range-value").val() };
    },

    /* Value validators - prepare values from widgets for Solr query */

    validate_unicode: function(c, values) {
        if (!values["value"]) {
            throw new Error(gettext("No value provided."));
        }
    },

    is_int: function(v) {
        return parseFloat(v) == parseInt(v) && !_.isNaN(v);
    },

    validate_ints: function(c, values) {
        if (!this.is_int(values["value"])) {
            throw new Error(gettext("Value is not an integer!"));
        }
        
        var value = parseInt(values["value"]);

        if (values["range_value"]) {
            if (!this.is_int(values["range_value"])) {
                throw new Error(gettext("Second value is not an integer!"));
            }

            var range_value = parseInt(values["range_value"]);
        } else {
            var range_value = null;
        }

        if (range_value) {
            if (value > range_value) {
                throw new Error(gettext("The first value should always be less than the second value.")); 
            }
        }
    },

    is_float: function(v) {
        return !_.isNaN(parseFloat(v));
    },
    
    validate_floats: function(c, values) {
        if (!this.is_float(values["value"])) {
            throw new Error(gettext("Value is not an float!"));
        }
        
        var value = parseFloat(values["value"]);

        if (values["range_value"]) {
            if (!this.is_float(values["range_value"])) {
                throw new Error(gettext("Second value is not an float!"));
            }

            var range_value = parseFloat(values["range_value"]);
        } else {
            var range_value = null;
        }

        if (range_value) {
            if (value > range_value) {
                throw new Error(gettext("The first value should always be less than the second value.")); 
            }
        }
    },

    validate_dummy: function(c, values) {
    },

    is_datetime: function(v) {
        return v.match(/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/);
    },

    validate_datetimes: function(c, values) {
        if (!this.is_datetime(values["value"])) {
            throw new Error(gettext('Datetime must be in format "YYYY-MM-DD HH:MM".'));
        }
        
        try {
            var value = moment(values["value"], "YYYY-MM-DD HH:mm");
        } catch (e) {
            throw new Error(gettext("Value is not a valid datetime."));
        }

        if (values["range_value"]) {
            if (!this.is_datetime(values["range_value"])) {
                throw new Error(gettext('Datetime must be in format "YYYY-MM-DD HH:MM".'));
            }
            
            try {
                var range_value = moment(values["range_value"], "YYYY-MM-DD HH:mm");
            } catch (e) {
                throw new Error(gettext("Second value is not a valid datetime."));
            }
        } else {
            var range_value = null;
        }

        if (range_value) {
            if (value > range_value) {
                throw new Error(gettext("The first date must be before the second date.")); 
            }
        }
    },

    is_date: function(v) {
        return v.match(/^\d{4}-\d{2}-\d{2}$/);
    },

    validate_dates: function(c, values) {
        if (!this.is_date(values["value"])) {
            throw new Error(gettext('Date must be in format "YYYY-MM-DD".'));
        }
        
        try {
            var value = moment(values["value"], "YYYY-MM-DD");
        } catch (e) {
            throw new Error(gettext("Value is not a valid date."));
        }

        if (values["range_value"]) {
            if (!this.is_date(values["range_value"])) {
                throw new Error(gettext('Date must be in format "YYYY-MM-DD".'));
            }
            
            try {
                var range_value = moment(values["range_value"], "YYYY-MM-DD");
            } catch (e) {
                throw new Error(gettext("Second value is not a valid date."));
            }
        } else {
            var range_value = null;
        }

        if (range_value) {
            if (value > range_value) {
                throw new Error(gettext("The first date must be before the second before.")); 
            }
        }
    },

    is_time: function(v) {
        return v.match(/^\d{2}\:\d{2}$/);
    },

    validate_times: function(c, values) {
        if (!this.is_time(values["value"])) {
            throw new Error(gettext('Time must be in format "HH:MM".'));
        }
        
        try {
            var value = "9999-12-31 " + values["value"];
            value = moment(value, "YYYY-MM-DD HH:mm");
        } catch (e) {
            throw new Error(gettext("Value is not a valid time."));
        }

        if (values["range_value"]) {
            if (!this.is_time(values["range_value"])) {
                throw new Error(gettext('Time must be in format "HH:MM".'));
            }
            
            try {
                var range_value = "9999-12-31 " + values["range_value"];
                range_value = moment(range_value, "YYYY-MM-DD HH:mm");
            } catch (e) {
                throw new Error(gettext("Second value is not a valid time."));
            }
        } else {
            var range_value = null;
        }

        if (range_value) {
            if (value > range_value) {
                throw new Error(gettext("The first time must be before the second time.")); 
            }
        }
    }
});

