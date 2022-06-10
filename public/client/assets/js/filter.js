console.log("ok");
window.onload = () => {
    const fiterCategorie = document.querySelector("#cat-filter");

    document.querySelectorAll("#cat-filter li").forEach(li =>{
        li.addEventListener("change", ()=>{
            console.log("clic");
        })
    })
}