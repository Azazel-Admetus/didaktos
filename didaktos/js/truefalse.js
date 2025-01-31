const config = document.getElementById('config');
const li = document.querySelectorAll('#config ul li');


config.addEventListener('click', (event) => {
    event.stopPropagation();
    li.forEach((li) => {
        if (li.style.display === 'block'){
            li.style.display = 'none';
        }else{
            li.style.display = 'block';
        }
    });
});
document.addEventListener('click', (e) => {
    if(!config.contains(e.target)){
        li.forEach((li) =>{
            li.style.display = 'none';
        });
    }
});
