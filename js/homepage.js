

function fetchLastActivity(){
    fetch("php/get_last_activity.php")
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json(); // Parse the JSON from the response
    })
    .then(data => {

        const timestamp = data.last_activity;

        const date = new Date(timestamp);

        const options = { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric' };
        const formattedDate = new Intl.DateTimeFormat('en-US', options).format(date);

        const parts = formattedDate.split(', '); // Split to get weekday and date separately
        const [weekday] = parts[0].split(' '); // Get the weekday
        const [day, month, year] = parts[1].split('/');


        const resultado = `on ${weekday} - ${month}.${day}.${year}`;//We put first month, since it changes its position with day

        document.getElementById("js-last-activity").innerHTML = resultado;
    })
    .catch(
        error => {
        console.error("Fetch error:", error);
    })


}

var myCarousel = document.getElementById('myCarousel')

myCarousel.addEventListener('slide.bs.carousel', function () {
  // do something...
  console.log('Carousel is sliding');
  console.log('Next slide index: ' + event.to);  // event.to gives you the index of the next slide
  console.log('Current slide index: ' + event.from);  // event.from gives you the index of the current slide
})
window.onload = fetchLastActivity();