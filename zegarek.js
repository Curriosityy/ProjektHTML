function showTextTime()
{
  var dataTeraz = new Date();
  document.querySelector('#fCzas').innerHTML = dataTeraz.getHours() + ":" + dataTeraz.getMinutes() + ":" + dataTeraz.getSeconds();
  setTimeout(function() {showTextTime() }, 1000);
}
showTextTime();
