var elements2 = document.getElementsByClassName("update");
            update = function() {
            var id = event.target.getAttribute('data-ressource');
            var imgsrc = document.getElementById('img-'+id).src;
            number = document.getElementById('num-'+id).innerHTML;
            console.log(imgsrc);
            //ondition pour l'url
            if (imgsrc == "{{ url('app_home')}}"+"assets/img/heart.svg"){
                var url = "{{ url('app_liker_update')}}"+"?idressource="+id+"&update=1";
                //convert string to int 
                number2 = parseInt(number, 10)+1;
                document.getElementById('num-'+id).innerHTML = number2.toString();
                document.getElementById('img-'+id).src = '/assets/img/heart-fill.svg';
            } else {
                var url = "{{ url('app_liker_update')}}"+"?idressource="+id+"&update=0";
                number2 = parseInt(number, 10)-1;
                document.getElementById('num-'+id).innerHTML = number2.toString();
                document.getElementById('img-'+id).src = '/assets/img/heart.svg';
            }
            
            //condition par rapport al la value
            const req = new XMLHttpRequest();
            req.open("GET", url);
            req.send();

            
        };
        Array.from(elements2).forEach(function(element) {
            element.addEventListener('click', update);
        });
        var elements = document.getElementsByClassName("newliker");
        console.log(elements);
            function newliker() {
            var id = event.target.getAttribute('data-ressource');
            var url =  "{{ url('app_liker_new') }}"+"?idressource="+id;
            console.log(url);
            const req = new XMLHttpRequest();
            req.open("GET", url);
            req.send();

            //changer le src img
            document.getElementById('img-'+id).src = '/assets/img/heart-fill.svg';
            //compteur +1 sauf si compteur trop grand
            number = document.getElementById('num-'+id).innerHTML;
            //convert string to int 
            number2 = parseInt(number, 10)+1;
            document.getElementById('num-'+id).innerHTML = number2.toString();
            //changer le onclick class event
            this.classList.remove("newliker");
            this.classList.add("update");
        };
        Array.from(elements).forEach(function(element) {
            element.addEventListener('click', newliker);
        });