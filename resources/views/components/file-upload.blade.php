<script>
    if (window.File && window.FileList && window.FileReader) {
        fileUpload = [];
        $(".close-btn").click(function() {
            fileUpload_del = [];
            $(this).parent(".photoFigure").remove();
            // let val = $(this).parent().parent().parent().children().eq(1).attr('src');
            let val = $(this).parents(".photoFigure").children().next().next().val();
            fileUpload.push(val);
            $('#deleteFiles').val(fileUpload);
        });

        $(".radioBtn").on('click', function() {
            $(".photoFigure").removeClass("active");
            $(this).parents(".photoFigure").addClass('active');
            $(this).parent().parent().addClass('active');
            let headFile = $(this).parents(".photoFigure").children().next().next().val();
            $('#headFile').val(headFile);
            console.log(headFile);
        });

        $("#fileUpload").on("change", function(e) {
            var files = e.target.files;

            filesLength = files.length;

            for (var i = 0; i < filesLength; i++) {
                var f = files[i]

                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;

                    // console.log(e.target)
                    let template = `<figure class="photoFigure">
                                <span class="img-title">{{ __('hotel.main_photo')}}</span>
                                <img  src="${file.result}" />
                                <input type="hidden" value="${file.result}" name="Upload[]" id="Upload" class="form-control">
                                <figcaption>

                        <span class="round"></span>


                                    <label for="img${i}">
											<button type="button" id="img${i}" class="radioBtn">{{ __('hotel.main_photo')}} </button>
								    </label>
								</figcaption>
                                <button class="close-btn" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <g id="Group_85" data-name="Group 85" transform="translate(-981 -281)">
                                            <rect id="Rectangle_151" data-name="Rectangle 151" width="21.213" height="1.414" transform="translate(982 281) rotate(45)" fill="#1d1d1d" />
                                            <rect id="Rectangle_152" data-name="Rectangle 152" width="21.213" height="1.415" transform="translate(997 282.001) rotate(135)" fill="#1d1d1d" />
                                        </g>
                                    </svg>
                                </button>
                            </figure>`
                    val = $('#each-photo-block');
                    val.append(template)

                    // $('#each-photo-block').append(template)

                    // console.log(file.name)
                    $(".close-btn").click(function() {
                        console.log($('#Upload').val());
                        $(this).parent(".photoFigure").remove();
                        let val = $(this).parent().parent().parent().children().eq(1).attr('src');
                        fileUpload = fileUpload.splice(fileUpload.indexOf(val), 1)
                        console.log(fileUpload)
                    });

                    $(".radioBtn").on('click', function() {
                        $(".photoFigure").removeClass("active");
                        $(this).parents(".photoFigure").addClass('active');
                        $(this).parent().parent().addClass('active');
                        let headFile = $(this).parents(".photoFigure").children().next().next().val();
                        $('#headFile').val(headFile);
                        console.log(headFile);
                    });

                });
                fileReader.readAsDataURL(f);
            }
        });
        console.log(fileUpload.length)
    } else {
        alert("Your browser doesn't support to File API")
    };
</script>
