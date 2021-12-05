document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.table-responsive').forEach(function(table){
        let labels = Array.from(table.querySelectorAll('th')).map(function (th) {
            return th.innerText
        })

        table.querySelectorAll('td').forEach(function (td, i){
            td.setAttribute('data-label', labels[i % labels.length])
        })

    })
    //Pour chaque tableau table
        //Pour chaque th dans table
            //Je collecte les labels
        //Pour chaque td dans table
            //On récupère l'index du td
            //On va mettre le data-label qui correspond
})


// method 1:
// let labels = []
// table.querySelectorAll('th').forEach(function (th) {
//     labels.push(th.innerText)
// })