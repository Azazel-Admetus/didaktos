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
// vamos cuidar da parte do feed
document.addEventListener("DOMContentLoaded", () =>{
    fetch("../php/explorar.php")
        .then(response=>response.json())
        .then(jogos=>{
            const feed = document.getElementById("feed");
            feed.innerHTML = "";
            if (jogos.length === 0){
                feed.innerHTML ="<p>Nenhum jogo disponível no momento.</p>";
                return;
            }
            jogos.forEach(jogo =>{
                const jogoElement = document.createElement("div");
                jogoElement.classList.add("jogo-card");
                jogoElement.innerHTML =`
                    <h2>${jogo.titulo}</h2>
                    <p>${jogo.descricao}</p>
                    <span class="dificuldade ${jogo.dificuldade.toLowerCase()}">
                        ${jogo.dificuldade.toUpperCase()}
                    </span>
                `;
                feed.appendChild(jogoElement);
            });
        })
        .catch(error=>{
            console.error("ERro ao carregar jogos:", error);
            document.getElementById("feed").innerHTML = "<p>Erro ao carregar jogos.</p>";
        });
});