function openAddWindow(){
    let openaddpop = document.getElementById("openaddpop");
    openaddpop.classList.add("openAddpop");
}
function closeAddWindow(){
    let openaddpop = document.getElementById("openaddpop");
    openaddpop.classList.remove("openAddpop");
}
function OpenUpdate() {
    document.getElementById("updatepop").style.display = "block";
}
window.addEventListener('message', function(event) {
    if (event.data === 'closeIframe') {
      // Close the iframe or perform any other desired action
      let updatepop = document.getElementById('updatepop');
      updatepop.style.display = 'none';
    }
  });
