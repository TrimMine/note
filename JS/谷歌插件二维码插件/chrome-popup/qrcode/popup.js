let changeData = el => {
  const TIME = new Date();
  const HOUR = TIME.getHours() >= 10 ? TIME.getHours() : '0' + TIME.getHours();
  const MINUTE = TIME.getMinutes() >= 10 ? TIME.getMinutes() : '0' + TIME.getMinutes();
  const SECOND = TIME.getSeconds() >= 10 ? TIME.getSeconds() : '0' + TIME.getSeconds();
  el.text(HOUR + ':' + MINUTE + ':' + SECOND);
  setTimeout(() => {
    changeData(el);
  }, 1000);
}

let changeUrlInput = url => {
  const urlLineNum = Math.ceil(url.length / 16) * 1.2;
  $('#input').css('height', 'calc(' + urlLineNum + 'em + 20px)');
  document.getElementById("qr-code").innerHTML = '';
  var qrcode = new QRCode(document.getElementById("qr-code"), {
    text: url,
    width: 150,
    height: 150,
    colorDark : "#09f",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
  });
}

chrome.tabs.getSelected(data => {
  $('#show-img').attr('src', data.favIconUrl || './images/default.png');
  $('#input').val(data.url);
  changeUrlInput(data.url);
});

$('#input').on('input', () => {
  changeUrlInput($('#input').val());
});




const SHOW_TIME = $('#time');
changeData(SHOW_TIME);