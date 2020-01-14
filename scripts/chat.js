function init(){
    listStyles()
    setCurrentStylesheet()
}

function activateChat(e){
    
    if(e.target.checked){
        document.getElementById('container').style = "opacity:1;"
        waitForMessages(true)
    }else{
        document.getElementById('container').style =  " opacity:0;"   
        if(xhr) xhr.abort()     
    }
}




function waitForMessages(first=false){
    xhr = new XMLHttpRequest()
    method = "GET"
    send_date = Date.now()
    send_date = get10DigitNumber(send_date)
    url = 'actions/get_messages.php?timestamp='+ send_date
    if(first) url += '&first=true'
    async = true
    xhr.open(method, url, async)
    now = new Date().toISOString()
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function() {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            // console.log(xhr)
            received = JSON.parse(xhr.responseText)
            // console.log(received)
            createMessages(received['content'],'messages')
            waitForMessages()
        }
    }
    xhr.send()
}

function sendMessage(e){
    e.preventDefault();
    data = formToDict(e.target.elements)
    e.target.reset()
    xhr1 = new XMLHttpRequest()
    method = "POST"
    url = 'actions/add_message.php'
    async = true
    xhr1.open(method, url, async)
    xhr1.setRequestHeader('Content-Type', 'application/json');
    xhr1.onreadystatechange = function() {
        if(xhr1.readyState == XMLHttpRequest.DONE && xhr1.status == 200){
            if(xhr1.responseText) alert (JSON.parse(xhr1.responseText))
        }
    }
    xhr1.send(JSON.stringify(data))
}


