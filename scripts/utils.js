  /**
 * Checks if given element, be packed to jsono bject
 * @param {*} element 
 */
const isValidElement = element => {
  return element.name && element.value
}

/**
* Converts form output to dictionary 
* @param {*} elements - list of form elements 
*/
const formToDict = elements => [].reduce.call(elements, (data, element) => {
  if (isValidElement(element)) data[element.name] = element.value
  return data
}, {})


/**
 * Default init function. Could be overwrited in other files
 */
function init(){
  listStyles()
  setCurrentStylesheet()
}

/**
 * Set date to current date on input
 * @param {string} dateInputId - input date id
 * @returns void 
 */
function setDateToToday(dateInputId){
    const dateInput = document.getElementById(dateInputId);
    const today = new Date()
    dateInput.valueAsDate = today

}

/**
 * Set time to current timme
 * @param {string} timeInputId 
 */
function setTimeToCurrent(timeInputId){
    const timeInput = document.getElementById(timeInputId)
    const today = new Date()
    var time = today.getHours().toString().padStart(2,'0') + ':' + today.getMinutes().toString().padStart(2,'0');	
    timeInput.value = time
}

function listStyles(){
    tomorrow = new Date()
    var head = document.getElementsByTagName('head')[0]
	var styles = head.getElementsByTagName('link');
	var list = document.getElementById('menu');
    var index = -1
    for(style of styles){
        index += 1
        if (style.title == "") continue
        else if(style.title == "Default" && getCookie("active_style") === null) {
            setCookie('active_style',index,1)
            // localStorage.setItem('active_style',index)
        }
		var item = document.createElement('li')
		var link = document.createElement('a')
        link.innerHTML = style.title;
        // link.href = style.href; 
        item.value = index
        item.onclick = activateStylesheet 
		item.appendChild(link);
		list.appendChild(item);	
	}
}

function activateStylesheet(e){
    index = e.target.value
    previousStylesheet = parseInt(getCookie('active_style'))
    // previousStylesheet = JSON.parse(localStorage.getItem('active_style'))
    document.styleSheets[previousStylesheet].disabled = true
    document.styleSheets[index].disabled = false
    setCookie('active_style',index,1)
    // localStorage.setItem('active_style',index)
}

function setCurrentStylesheet(){
    if (getCookie("active_style") === null) return
    // index = JSON.parse(localStorage.getItem('active_style'))
    index = parseInt(getCookie('active_style'))
    document.styleSheets[index].disabled = false
}


function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return null
  }


  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  

  /**
   * Get 10 first digits from timestamp
   * @param {*} num 
   */
  function get10DigitNumber(num){
    d = num.toString()
    r = []
    for (i=0;i<10;++i){
      r.push(d[i])
    }
    n = r.join('')
    return parseInt(n)

  }

/**
 * Create messages for provided data
 * @param {*} content - text separated by newline characters
 * @param {*} container_id - id of container
 */
function createMessages(content, container_id){
  const container = document.getElementById(container_id)
  container.innerHTML = ""
  messages = content.split('\n')
  for(message of messages){
    message_container = document.createElement('li')
    message_container.classname = 'message-container'
    message_container.innerHTML = message
    container.appendChild(message_container)
  }
}