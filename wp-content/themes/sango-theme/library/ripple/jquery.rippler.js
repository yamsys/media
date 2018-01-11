/*!
 * rippler v0.1.1
 * http://blivesta.github.io/rippler/
 * Licensed under MIT
 * Author : blivesta
 * http://blivesta.com/
 */
(function($) {
  "use strict";
  var namespace = "rippler";
  var methods = {
    init: function(options) {
      options = $.extend({
        effectClass: "rippler-effect",
        effectSize: 16,
        addElement: "div",
        duration: 600
      }, options);
      return this.each(function() {
        var _this = this;
        var $this = $(this);
        var data = $this.data(namespace);
        if (!data) {
          options = $.extend({}, options);
          $this.data(namespace, {
            options: options
          });
          if (typeof document.ontouchstart != "undefined") {
            $this.on("touchstart." + namespace, function(event) {
              var $self = $(this);
              methods.elementAdd.call(_this, $self, event);
              this.isTouch = true;
            });

            $this.on("touchmove." + namespace, function(event) {
              this.isTouch = false;
            });           

            $this.on("touchend." + namespace, function(event) {
              if(this.isTouch == true){
              var $self = $(this);
              methods.effect.call(_this, $self, event);}
            });
          } else {
            $this.on("mousedown." + namespace, function(event) {
              var $self = $(this);
              methods.elementAdd.call(_this, $self, event);
            });
            $this.on("mouseup." + namespace, function(event) {
              var $self = $(this);
              methods.effect.call(_this, $self, event);
            });
          }
        }
      });
    },
    template: function(options) {
      var $this = $(this);
      options = $this.data(namespace).options;
      var element;
      var svgElementClass = "rippler-svg";
      var divElementClass = "rippler-div";
      var circle = '<circle cx="' + options.effectSize + '" cy="' + options.effectSize + '" r="' + options.effectSize / 2 + '">';
      var svgElement = '<svg class="' + options.effectClass + " " + svgElementClass + '" xmlns="http://www.w3.org/2000/svg" viewBox="' + options.effectSize / 2 + " " + options.effectSize / 2 + " " + options.effectSize + " " + options.effectSize + '">' + circle + "</svg>";
      var divElement = '<div class="' + options.effectClass + " " + divElementClass + '"></div>';
      if (options.addElement === "svg") {
        element = svgElement;
      } else {
        element = divElement;
      }
      return element;
    },
    elementAdd: function($self, event, options) {
      var _this = this;
      var $this = $(this);
      options = $this.data(namespace).options;
      $self.append(methods.template.call(_this));
      var $effect = $self.find("." + options.effectClass);
      var selfOffset = $self.offset();
      var eventX = methods.targetX.call(_this, event);
      var eventY = methods.targetY.call(_this, event);
      $effect.css({
        width: options.effectSize,
        height: options.effectSize,
        left: eventX - selfOffset.left - options.effectSize / 2,
        top: eventY - selfOffset.top - options.effectSize / 2
      });
    },
    effect: function($self, event, options) {
      var _this = this;
      var $this = $(this);
      options = $this.data(namespace).options;
      var $effect = $("." + options.effectClass);
      var selfOffset = $self.offset();
      var thisW = $this.outerWidth();
      var thisH = $this.outerHeight();
      var effectMaxWidth = methods.diagonal(thisW, thisH) * 2;
      var eventX = methods.targetX.call(_this, event);
      var eventY = methods.targetY.call(_this, event);
      var url = $self.attr("href");
      $effect.css({
        width: effectMaxWidth,
        height: effectMaxWidth,
        left: eventX - selfOffset.left - effectMaxWidth / 2,
        top: eventY - selfOffset.top - effectMaxWidth / 2,
        transition: "all " + options.duration / 1e3 + "s ease-out"
      }).transitionEnd(function() {
        if (url && (navigator.userAgent.indexOf('iPhone') > 0 || navigator.userAgent.indexOf('iPad') > 0 || navigator.userAgent.indexOf('Android') > 0)) {
          location.href = url;
        }
        return methods.elementRemove.call(_this);
      });
    },
    elementRemove: function(options) {
      var $this = $(this);
      options = $this.data(namespace).options;
      var $effect = $("." + options.effectClass);
      $effect.css({
        opacity: 0
      }).transitionEnd(function() {
        $effect.remove();
      });
    },
    targetX: function(event) {
      var e = event.originalEvent;
      var eventX;
      if (typeof document.ontouchstart != "undefined") {
        eventX = e.changedTouches[0].pageX;
      } else {
        eventX = e.pageX;
      }
      return eventX;
    },
    targetY: function(event) {
      var e = event.originalEvent;
      var eventY;
      if (typeof document.ontouchstart != "undefined") {
        eventY = e.changedTouches[0].pageY;
      } else {
        eventY = e.pageY;
      }
      return eventY;
    },
    diagonal: function(x, y) {
      if (x > 0 && y > 0) return Math.sqrt(Math.pow(x, 2) + Math.pow(y, 2)); else return false;
    },
    destroy: function() {
      return this.each(function() {
        var $this = $(this);
        $(window).unbind("." + namespace);
        $this.removeData(namespace);
      });
    }
  };
  $.fn.transitionEnd = function(callback) {
    var $this = $(this);
    var props = "transitionend webkitTransitionEnd mozTransitionEnd oTransitionEnd MSTransitionEnd";
    if ($this.length > 0) {
      $this.bind(props, function(event) {
        if ($.isFunction(callback)) {
          callback.call($this, event);
        }
      });
    }
    return $this;
  };
  $.fn.rippler = function(method) {
    if (methods[method]) {
      return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof method === "object" || !method) {
      return methods.init.apply(this, arguments);
    } else {
      $.error("Method " + method + " does not exist on jQuery." + namespace);
    }
  };
})(jQuery);
$(document).ready(function() {
  $(".rippler").rippler({
    effectClass      :  'rippler-effect'
    ,addElement      :  'div'   // e.g. 'svg'(feature)
    ,effectSize      :  0
    ,duration        :  300
  });
    if (navigator.userAgent.indexOf('iPhone') > 0 || navigator.userAgent.indexOf('iPad') > 0 || navigator.userAgent.indexOf('Android') > 0) {
     $('.rippler').on('click', function(){
        return false;
      });
    }
});
