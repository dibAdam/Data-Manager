let btn_input = document.getElementById('unique_input');
let btn_result = document.getElementById('btn_result');
let fileInput = document.getElementById('txt_file_input');

var filePath = fileInput.value;

btn_result.addEventListener('click', () => {
    
    // const selectedFile = fileInput.files[0];
    // fetch(selectedFile)
    // .then(response => response.text())
    // .then(text => console.log(text))

        // var reader = new FileReader();
        // reader.onload = function() {
        //   var text = reader.result;
        //   var lines = text.split('\n');
        //   var domain = [];

        //   //object stores all the value and n times repeated
        //   const count = {};

        //     for (var line = 0; line < lines.length; line++) {
        //         var gmail_splited = lines[line].split('@')
        //         domain.push(gmail_splited[1])
                

        //     }
        //     //unique array from the existing array domain
        //     var uniqueSet = removeDuplicates(domain)
        //     // console.log(uniqueSet)

        //     domain.forEach(element => {
        //         count[element] = (count[element] || 0) + 1;
        //     });
        //     console.log(count);
        // };
        // //this line of code is necessary to read the txt file
        // reader.readAsText(fileInput.files[0]);



});

//this is a function that returns a new unique array from an old one
function removeDuplicates(arr) {
    return [...new Set(arr)];
}



// 👇️ {one: 3, two: 2, three: 1}
