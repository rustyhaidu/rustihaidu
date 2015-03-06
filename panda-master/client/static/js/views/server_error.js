PANDA.views.ServerError = Backbone.View.extend({
    text: PANDA.text.ServerError(),

    initialize: function() {
        _.bindAll(this);
    },

    reset: function(path) {
        this.render();
    },

    render: function() {
        var context = PANDA.utils.make_context({
            text: this.text
        });

        this.$el.html(PANDA.templates.server_error(context));
    }
});

