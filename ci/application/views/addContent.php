<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html>
<style>
button:focus{
    outline: none;
}

body{
    color:white !important;
    background-color: #191919 !important;
    font-family: 'Raleway', sans-serif !important;
}

.table{
    width:80% !important;
    margin-left:10%;
}

.form-control{
    margin-bottom:50px;
}

.title{
    font-size: 15px;
    display:inline-block;
    letter-spacing:5px;
    margin: 20px;
    color:white;
    text-decoration:none;
    text-transform: uppercase;
    background: transparent;
    border: none;
}


.title:hover{
    color:#8e8e8e;
}


.col-lg-10{
    margin-left:10%;
    margin-right:10% !important;
}


.menu{
    text-align: center;
    margin: 30px;
    margin-bottom:100px;
}

.add_content{
    text-align:center;
}

.textBox{
    margin-top:10px;
    margin-bottom:30px;
}

#page2{
    display:none;
}

#searchbox{
    color: black;
    padding: 3px;
    border-radius: 4px;
    border: none;
    width:100%;
}

.searchContent{
    margin-left: 10%;
    width: 40%;
    margin-bottom:130px;

}

.search-list{
    position: absolute;
    background-color: white;
    color: blue;
    padding: 0;
}

.search-list-item{
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    padding: 5px 15px;
    user-select: none;
    cursor: pointer;
}

.search-list-item:hover{
    background-color: lightblue;
}

table tr:last-child td:first-child {
    border-bottom-left-radius: 10px !important;
}

table tr:last-child td:last-child {
    border-bottom-right-radius: 10px !important;
}
</style>
<head>
    <title>UKIFF</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="menu">
                <button id="add" class="title">Add Content</button>
                <button id ="search" class="title">Search</button>
            </div>
        </div>
        <form id="page1" class="row" method="post" action="<?php echo base_url('/index.php/ukiff/ajaxRequestPost');?>">
            <div class="col-lg-10">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name..">
            </div>
            <div class="col-lg-10">
                <strong>Description:</strong>
                <textarea name="description" class="form-control" placeholder="Description.."></textarea>
            </div>
            <div class="col-lg-10">
                <br/>
                <button type="submit" id="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>

    <div id="page2">
        <div class="searchContent">
            <input type="text" id="searchbox" placeholder="Search..">
            <div class="search-list"></div>
        </div>

        <table class="table table-bordered" style="margin-top:20px">
            <thead style="background: #292828;">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody id="display-table"></tbody>
        </table>
    </div>

    <script>
    $('#searchbox').on("input", function(e) {
        $.ajax({
           url: "<?php echo base_url('/index.php/ukiff/searchNames');?>",
           type: 'POST',
           data: {term: this.value},
           error: function() {
              alert('Something is wrong');
           },
           success: function(data) {
                data = JSON.parse(data);
                let list = document.querySelector(".search-list");
                list.innerHTML = "";
                for(let i = 0; i < data.length; i++){
                    let li = document.createElement("div");
                    li.className = "search-list-item";
                    li.innerHTML = data[i].name;
                    li.description = data[i].description;
                    li.recordId = data[i].id;
                    list.appendChild(li);
                }
                $(".search-list-item").unbind();
                $(".search-list-item").on("click", function(){
                    let prev = document.querySelectorAll(".display-item");
                    let existing = false;
                    for(let i = 0; i < prev.length; i++){
                        if(prev[i].recordId === this.recordId) existing = true;
                    }

                    if(!existing){
                        let r = document.createElement("tr");
                        let d1 = document.createElement("td");
                        let d2 = document.createElement("td");

                        r.recordId = this.recordId;
                        r.className = "display-item";
                        d1.innerHTML = this.innerHTML;
                        d2.innerHTML = this.description;
                        r.appendChild(d1);
                        r.appendChild(d2);
                        document.getElementById("display-table").appendChild(r);
                    }
                });
           }
        });
    });

    $('#add').click(function() {
        $('#page1').css("display", "block");
        $('#page2').css("display", "none");
    });

    $('#search').click(function() {
        $('#page2').css("display", "block");
        $('#page1').css("display", "none");
    });
    </script>
</body>
</html>
