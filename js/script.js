//site namespace
var myBlog = (function(){
    
    function textArea(element, maxlen, callback) {
        var counter = 0,
            maxlen = maxlen,
            callback = callback;
        
        this.element = element;
        
        /*called when the value of the TextArea changes */
        this.charCount = function(){
            counter = maxlen - element.value.length;
            callback(counter);
        };
        
        /*checks if you're not out of characters */
        this.charCheck = function(){
            if (counter < 0) return false;
            return true;
        };
    };
    
    /* toggles DOM element display on and off */
    function toggle(element){

        var btn = document.getElementById(element);
        if(btn.style.display=="none"){
            btn.style.display="block";
        } else {
            btn.style.display="none";  
        }
    }
    
    /*
        element - a TextArea
        maxlen - the amount of characters to limit too
        callback - function that is called when the elements value changes
        
        returns a textArea object 
        Use the textAreas charCount function with your forms onsubmit.
        */
    var limitCharacters = function(element, maxlen, callback) {  
        
        var e = new textArea(element, maxlen, callback);
        e.element.onkeypress = e.charCount;
        e.element.onkeydown = e.charCount;
        e.element.onkeyup = e.charCount;
        e.callback = callback;
        e.charCount();
        
        return e;
    }; 
     
    return {toggle : toggle,
           limitCharacters: limitCharacters};
})();