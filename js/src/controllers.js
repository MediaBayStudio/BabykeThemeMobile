jQuery(".up-font-deploy").click(function () {
  jQuery("html").css('fontSize', function(index, value){
      var newSize = parseInt(value.replace('px',''))+2;
      if (newSize <= 22)
        return newSize;
  });
});

jQuery(".down-font-deploy").click(function () {
  jQuery("html").css('fontSize', function(index, value){
      var newSize = parseInt(value.replace('px',''))-2;
      if (newSize >= 12)
        return newSize;
  });
});
