/* Link Page
===================================================================================================================== */

import $ from 'jquery';

$(function() {
  
  $('.linkpage div.categories > section.category').each(function() {
    
    var $self   = $(this);
    var $header = $self.find('header');
    
    // Detect Start Open Status:
    
    if ($self.data('start-open')) {
      $header.addClass('opened');
    }
    
    // Handle Header Click:
    
    $header.on('click', function() {
      $(this).toggleClass('opened');
    });
    
  });
  
});
