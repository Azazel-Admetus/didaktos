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
document.querySelectorAll('.card').forEach(card => {
    const dificuldade = card.dataset.dificuldade;

    switch (dificuldade) {
        case 'fácil':
            card.style.borderColor = 'green';
            break;
        case 'médio':
            card.style.borderColor = 'yellow';
            break;
        case 'difícil':
            card.style.borderColor = 'red';
            break;
        default:
            card.style.borderColor = 'gray';
    }
});
