$(document).ready(function(e) {
      $('.selectpicker').selectpicker();
      
       $(':reset').on('click', function(evt) {
        evt.preventDefault()
        $form = $(evt.target).closest('form')
        $form[0].reset()
        $form.find('select').selectpicker('render')
    });
});