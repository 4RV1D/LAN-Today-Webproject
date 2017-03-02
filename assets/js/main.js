
$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});

$("input[name='imageUpload']").on("change", function() {

  var files = !!this.files ? this.files : [];
  if (!files.length || !window.FileReader) return;

  if (/^image/.test(files[0].type)) {

    var reader = new FileReader();
    reader.readAsDataURL(files[0]);

    reader.onloadend = function() {
      $(".avatar").css("background-image", "url(" + this.result + ")");
      $(".submit").show(500);
    }
  }
});
