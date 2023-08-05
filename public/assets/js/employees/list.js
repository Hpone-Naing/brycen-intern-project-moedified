/**
 * In employee list page's search by career path and level,
 * when you choose search by career path or level dropdown list assign their key(index) to input type hidden for server site operation,
 * and assigned their value(readable text) to tooltip text title attribute for show user.
 */
$(document).ready(function () {
  $('.level-item').on('click', function () {
      var choosedItemValue = $(this).attr("value");
      var choosedItem = $(this).text();
      $('button.level-btn').text(choosedItem);
      $('i.level-select').attr('title', choosedItem);
      $('input[type="hidden"][name="level"]').val(choosedItemValue);
  });

  $('.career-item').on('click', function () {
    var choosedItemValue = $(this).attr("value");
    var choosedItem = $(this).text();
    $('button.career-btn').text(choosedItem);
    $('i.career-select').attr('title', choosedItem);
    $('input[type="hidden"][name="career_path"]').val(choosedItemValue);
  });
});
