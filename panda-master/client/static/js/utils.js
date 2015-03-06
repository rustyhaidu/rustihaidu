/*
 * This module contains global utilities--mostly jQuery extensions.
 */

if (typeof String.prototype.startsWith != 'function') {
    String.prototype.startsWith = function (str) {
        return this.slice(0, str.length) == str;
    };
}

Array.prototype.equals = function(arr) {
    /*
     * From: http://stackoverflow.com/questions/4978444/array-equality-checking-algorithm-not-working-in-certain-cases
     */
    if (this.length !== arr.length) {
        return false;
    }

    for (var i = 0; i < arr.length; i++) {
        if (this[i].equals) {
            if (!this[i].equals(arr[i])) {
                return false;
            } else {
                continue;
            }
        }

        if (this[i] !== arr[i]) {
            return false;
        }
    }

    return true;
}

$.fn.serializeObject = function() {
    /*
     * Serialize a form to a Javascript object.
     */
    var obj = {};
    var arr = this.serializeArray();

    $.each(arr, function() {
        if (obj[this.name] !== undefined) {
            if (!obj[this.name].push) {
                obj[this.name] = [obj[this.name]];
            }
            obj[this.name].push(this.value || '');
        } else {
            obj[this.name] = this.value || '';
        }
    });

    return obj;
};

$.fn.alert = function(type, message, close_button) {
    /*
     * Display a Twitter bootstrap alert with an optional close button.
     */
    this.hide();
    this.removeClass("alert-warning alert-error alert-success alert-info").addClass(type);

    if (_.isUndefined(close_button)) {
        close_button = true;
    }

    if (close_button) {
        this.html('<a class="close" href="#">&times;</a>' + message);
    } else {
        this.html(message);
    }

    this.show();
}

$.fn.alert_block = function(type, title, message, close_button) {
    this.alert("alert-block " + type, '<h4 class="alert-heading">' + title + "</h4> " + message, close_button);
}

$.fn.show_errors = function(errors, alert_prefix) {
    /*
     * Takes a set of errors in the Django-forms format:
     * { "field_id": ["error1", "error2" ] }
     * and displays them on a Twitter Bootstrap form.
     */
    if (!alert_prefix) {
        alert_prefix = "";
    }

    // Clear old errors
    $(this).find(".alert").first().hide();
    $(this).find(".control-group").removeClass("error");
    $(this).find(".help-inline").text("");

    // Show global errors in an alert
    if ("__all__" in errors) {
        $(this).find(".alert").first().alert_block("alert-error", alert_prefix, errors["__all__"] + ".");
    }

    _.each(errors, _.bind(function(field_errors, field) {
        // Only render one error at a time
        var error = field_errors[0];

        var input = $(this).find('input[name="' + field + '"]');

        if (input) {
            input.parents(".control-group").addClass("error");
            input.siblings(".help-inline").text(error);
        }
    }, this));
}

moment.fn.toLocalTimezone = function() {
    /*
     * Convert UTC datetimes to the user's local timezone.
     */
    return this.subtract("minutes", this._d.getTimezoneOffset());
}

$(".alert .close").live("click", function() {
    /*
     * Close handler for alerts.
     */
    $(this).parent().hide();
    
    return false;
});

