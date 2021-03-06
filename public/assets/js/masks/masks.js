$(document).ready(function(){

  $(function() {
    $('.moeda').maskMoney();
  })

  $('#date').mask('00/00/0000');
  $('.time').mask('00:00', {placeholder: "__:__"});
  $('#state').mask('AA', {placeholder: "PR"});
  $('#date_time').mask('00/00/0000 00:00:00');
  $('#cep').mask('00000-000', {placeholder: "00000-000"});
  $('#phone').mask('(00)00000-0000', {placeholder: "(00) 00000-0000"});
  $('#phone_with_ddd').mask('(00) 0000-0000', {placeholder: "(00) 0000-00000"});
  $('#cel').mask('(00) 0000-0000', {placeholder: "(00) 0000-00000"});
  $('#phone_us').mask('(000) 000-0000');
  $('#mixed').mask('AAA 000-S0S');
  $('.placa').mask('AAA-9999');
  $('#cpf').mask('000.000.000-00', {placeholder: "000.000.000-00"});
  $('#cnpj').mask('00.000.000/0000-00', {placeholder: "00.000.000/0000-00"});
  $('#money').mask('000.000.000.000.000,00', {reverse: true});
  // $('.moeda').mask("R$000,00", {placeholder: "R$00,00"});
  $('.phone').mask('(00)00000-0000', {placeholder: "(00) 00000-0000"});
  $('#ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
    translation: {
      'Z': {
        pattern: /[0-9]/, optional: true
      }
    }
  });
  $('#ip_address').mask('099.099.099.099');
  $('#percent').mask('##0,00%', {reverse: true});
  $('#clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
  $('#data').mask("00/00/0000", {placeholder: "__/__/____"});
  $('#fallback').mask("00r00r0000", {
      translation: {
        'r': {
          pattern: /[\/]/,
          fallback: '/'
        },
        placeholder: "__/__/____"
      }
    });
  $('#selectonfocus').mask("00/00/0000", {selectOnFocus: true});
});