$(document).ready(function() {
    function toggleAltStyle() {
      // note this ham-handedly toggles *ALL* alt-styles
      $('link[rel*=stylesheet]').each(function(i)
      {
        if (this.rel == "stylesheet") {
            this.rel = "alternate stylesheet";
            this.disabled = true;
        }
        else if (this.rel == "alternate stylesheet") {
            this.rel = "stylesheet";
            this.disabled = false;
        }
      });
    }

    var UP = 38,
        DOWN = 40,
        LEFT = 37,
        RIGHT = 39,
        B = 66,
        A = 65,

        konamiCode = [UP, UP, DOWN, DOWN, LEFT, RIGHT, LEFT, RIGHT, B, A],
        nextIndex = 0,
        
        intolerant = false;


    $("html").keyup(function(event) {
        console.log("Received " + event.which);
        console.log("Looking for " + konamiCode[nextIndex]);
        if (event.which === konamiCode[nextIndex]) {
            nextIndex++;

            if (nextIndex === konamiCode.length) {
                toggleAltStyle();
                nextIndex = 0;
            }

        } else if (intolerant) {
            nextIndex = 0;
        }
    });
});