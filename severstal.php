<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <title>Rivers on high mountains</title>
    <style>

    #app {
        display: flex;
        padding-top: 100px;
        padding-left: 200px;
    }
    .cube {
        height: 50px;
        width: 50px;
        background-color: #ca931f;
        margin:1px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        color: brown;
    }
    .column {
        display: flex;
        flex-direction: column-reverse;
    }
    .water {
        height: 50px;
        width: 50px;
        background-color: rgb(26, 123, 187);
        margin:1px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        color: brown;
    }

    h1{
            text-align:center;
            font-size:28px;
            font-family: 'Open Sans light', sans-serif;
            margin-top:60px;
        }
/* 
        Old version */

        /* h1{
            text-align:center;
            font-size:28px;
            font-family: 'Open Sans light', sans-serif;
            margin-top:60px;
        }

        .container{
            border-bottom: 2px solid black;
            border-left: 2px solid black;
            width: 560px;
            margin: 0 auto;
            margin-top: 95px;
        }

        .container ul{
            display:inline-block;
            vertical-align:bottom;
            padding:0;
            margin:0;
        }

        .container ul li{
            list-style: none;
            background-color: #e2af26;
            height: 20px;
            width: 20px;
            border: 3px solid brown;
        }

        #goRain{
            text-align: center;
            margin-top: 30px;
        }

        #goRain a{
            text-decoration: none;
            color: white;
            background: brown;
            font-family: 'Open Sans';
            padding: 10px 17px;
            border-radius: 6px;
            cursor:pointer;
        }

        #goRain a:hover{
            opacity:.8;
        }

        li.blue{
            background-color: blue !important;
            border-color: #03a8d2 !important;
            opacity: 0.5;
        } */
    </style>
</head>
<body>
    <h1>River on hig mountains</h1>
    <div id="app"></div>
    <!-- Old version -->
    <!-- <div class="container"></div>
    <div id="goRain">
        <a>Начать дождь</a>
    </div> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>



window.onload = () => {
    const app = document.getElementById('app');
    const coors = [1, 2, 3, 4, 6, 3, 2, 4, 7, 3, 4, 6, 1, 2, 1];

    const highest = coors.map(v => v).sort().reverse()[0];

    for (const el of coors) {
        let col = createColumn();

        for (let i = 0; i < el; i++) {
            const cube = createCube();
            cube.innerHTML = i + 1;

            col.appendChild(cube);
        }

        for (let j = 0; j < highest - el; j++) {
            const cube = createWater();
            cube.innerHTML = j + 1;
            col.appendChild(cube);
        }

        app.appendChild(col);
    }

    var colums =  Array.from(app.getElementsByClassName('column'));

    var copy = Object.assign({}, colums);

    for (let index = 0; index < colums.length; index++) {

        if (colums[index - 1]) {
            const groundLeft = colums[index - 1].getElementsByClassName('cube').length;
            const groundCenter = colums[index].getElementsByClassName('cube').length;

            if ((groundLeft > groundCenter)) {
                Array
                    .from(colums[index].getElementsByClassName('water'))
                    .forEach(v => colums[index].removeChild(v));
            }
            if ((groundLeft < groundCenter)) {
                Array
                    .from(colums[index - 1].getElementsByClassName('water'))
                    .forEach(v => colums[index - 1].removeChild(v));

            }
        }

    }


    let picks =  colums.map((v, i, a) => {
        const ind = Array.from(v.children).findIndex(z => z.classList.contains('water'));
        if ( ind> -1) {
            return {
                index: i,
                height: v.getElementsByClassName('cube').length
            };
        }
    });


    const picksAll = picks.filter(v => v).map((v, i, array) => {
        return {
            first: array[i],
            next: array[i + 1]
        }
    }).filter(v => v.first && v.next);


    for (const pick of picksAll) {
        const height = pick.first.height > pick.next.height ? pick.next.height : pick.first.height; 

        const start = pick.first.index + 1;
        for (let i = start; i < pick.next.index; i++) {
            const need = height - copy[i].children.length;


            for (let j = 0; j < need; j++) {
                copy[i].appendChild(createWater());
            }
        }


        Array.from(copy[pick.first.index].children).forEach((v, i, a) => {
            if (v.classList.contains('water')) {
                copy[pick.first.index].removeChild(v);
            }
        });

        Array.from(copy[pick.next.index].children).forEach((v, i, a) => {
            if (v.classList.contains('water')) {
                copy[pick.next.index].removeChild(v);
            }
        });
    }

}

function createColumn() {
    const column  = document.createElement('div');
    column.className = 'column';
    return column;
}

function createCube() {
    const column  = document.createElement('div');
    column.className = 'cube';
    return column;
}

function createWater() {
    const column  = document.createElement('div');
    column.className = 'water';
    return column;
}

// Old version
        // var container = document.querySelector('.container');
        // var arr = [1,2,3,4,6,3,2,4,7,3,4,6,1,2,1];
        // createMountain(container,arr);

        // var btn = document.querySelector('#goRain');
        // btn.addEventListener('click', () => {
        //     doRain(arr);
        // });

        // function doRain(arr){
        //     var max = 6;
        //     var superMax = 7;
        //     $('.container ul').each(function(){
        //         var current = $(this).children("ul>li").length;
        //         var next = $(this).next().children("ul>li").length;
        //         if(current > next && current == max){
        //             $(this).addClass('Big');
        //             // max = current;
        //         }
        //         else if(current == superMax){
        //             $(this).addClass('superMax');
        //         }
        //         if(current > next){  
        //             var diff = current - next;
        //             console.log(diff);
        //             $(this).next().addClass('blue');
        //             for(var i = 0;i < diff;i++){
        //                 $(this).next().addClass('qqq').prepend('<li class="blue"></li>');
        //             }
        //         }
                         
        //     });                  
        // }
        
        // function createMountain(container,arr){
        //     for(var i = 0;i<arr.length;i++){
        //         var ul = document.createElement('ul');
        //         var el = arr[i]; 
        //         for(var j = 0;j < el;j++){
        //             var li = document.createElement('li');
        //             ul.appendChild(li);
        //         }
        //         container.appendChild(ul);
        //     }
        // }
    </script>
</body>
</html>