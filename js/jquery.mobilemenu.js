!function (s) {
    s.fn.mobileMenu = function (e) {
        var a = s.extend({
            defaultText: "Opciones...",
            className: "select-menu",
            subMenuClass: "sub-menu",
            subMenuDash: "&ndash;"
        }, e), n = s(this);
        return this.each(function () {
            n.find("ul").addClass(a.subMenuClass), s("<select />", {class: a.className}).insertAfter(n), s("<option />", {
                value: "#",
                text: a.defaultText
            }).appendTo("." + a.className), n.find("a,.separator").each(function () {
                var e = s(this), n = e.text(), t = e.parents("." + a.subMenuClass).length;
                e.parents("ul").hasClass(a.subMenuClass) && (n = Array(t + 1).join(a.subMenuDash) + n), e.is("span") ? s("<optgroup />", {label: n}).appendTo("." + a.className) : s("<option />", {
                    value: this.href,
                    html: n,
                    selected: this.href == window.location.href
                }).appendTo("." + a.className)
            }), s("." + a.className).change(function () {
                "#" !== s(this).val() && (window.location.href = s(this).val())
            }), s(".select-menu").show()
        }), this
    }
}(jQuery);