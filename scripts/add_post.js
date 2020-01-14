function init(){
    setDateToToday('current_date')
    setTimeToCurrent('current_time')
    listStyles()
    setCurrentStylesheet()
}

function addBrowseField(e){
    const container = e.target.parentNode
    if(container.lastChild.value == "") return
    const newAttachemntNumber = parseInt(e.target.name.split('_')[1]) + 1
    newBrowse = document.createElement('input')
    newBrowse.type = 'file'
    newBrowse.name = 'att_' + newAttachemntNumber
    newBrowse.onchange = addBrowseField
    container.appendChild(newBrowse)
}

