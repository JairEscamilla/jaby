$("#exampleFormControlFile1").change(function(){
    var files = this.files;
    $(files).each(function(index, file){
        var url = URL.createObjectURL(file)
        $('.pic').css('background-image', 'url(' + url + ')');
    });
     $(".pic").addClass("picture-loaded");
});