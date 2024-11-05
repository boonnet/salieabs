//darkmode
const chk = document.getElementById('niwax');
chk.addEventListener('click', () => {
  chk.checked?document.body.classList.add("active-dark"):document.body.classList.remove("active-dark");
  localStorage.setItem('darkModeStatus', chk.checked);
});
window.addEventListener('load', (event) => {
  if(localStorage.getItem('darkModeStatus')=="true"){
    document.body.classList.add("active-dark"); 
    document.getElementById('niwax').checked = true;
  }
});
