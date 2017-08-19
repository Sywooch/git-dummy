
<?php $gals = \app\modules\gallery\models\Gallery::find()->where('gallerycatid = 30 ')->all();

    if($gals):?>

        <div id="rt-showcase">
            <div class="rt-container homepage">
                <div class="rt-grid-12 rt-alpha rt-omega">
                    <div class="rt-block">
                        <div id="k2ModuleBox129" class="k2ItemsBlock">
                            <div id="camera-slideshow">
                                <div data-src="/images/ccb4e23c8aa216f1e96d31ab209c036b_XL.jpg" data-link="/index.php/component/k2/item/40-slide-1" data-thumb="/images/ccb4e23c8aa216f1e96d31ab209c036b_XS.jpg">
                                    <div class="camera_caption fadeIn">


                                        <a class="moduleItemTitle" href="/index.php/component/k2/item/40-slide-1">Analyze. Maintain. Grow.</a>
                                        <div>
                                            <a class="moduleItemReadMore" href="/index.php/component/k2/item/40-slide-1">
                                                <strong></strong>
                                                <span>Read More</span>
                                            </a>
                                        </div>




                                        <div class="clr"></div>




                                    </div>

                                </div>
                                <div data-src="/images/6f43b5263fbba79c5962514b85d34738_XL.jpg" data-link="/index.php/component/k2/item/41-slide-2" data-thumb="/images/6f43b5263fbba79c5962514b85d34738_XS.jpg">
                                    <div class="camera_caption fadeIn">


                                        <a class="moduleItemTitle" href="/index.php/component/k2/item/41-slide-2">Develop. Integrate. Complete.</a>
                                        <div>
                                            <a class="moduleItemReadMore" href="/index.php/component/k2/item/41-slide-2">
                                                <strong></strong>
                                                <span>Read More</span>
                                            </a>
                                        </div>




                                        <div class="clr"></div>




                                    </div>

                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            (function($){
                                $(window).load(function(){
                                    $('#camera-slideshow').camera({
                                        alignment			: "center", //topLeft, topCenter, topRight, centerLeft, center, centerRight, bottomLeft, bottomCenter, bottomRight
                                        autoAdvance			: true,	//true, false
                                        mobileAutoAdvance	: false, //true, false. Auto-advancing for mobile devices
                                        barDirection		: "leftToRight",	//'leftToRight', 'rightToLeft', 'topToBottom', 'bottomToTop'
                                        barPosition			: "bottom",	//'bottom', 'left', 'top', 'right'
                                        cols				: 6,
                                        easing				: "easeOutExpo",	//for the complete list http://jqueryui.com/demos/effect/easing.html
                                        mobileEasing		: "easeOutExpo",	//leave empty if you want to display the same easing on mobile devices and on desktop etc.
                                        fx					: "simpleFade",
//'random','simpleFade', 'curtainTopLeft', 'curtainTopRight', 'curtainBottomLeft', 'curtainBottomRight', 'curtainSliceLeft', 'curtainSliceRight', 'blindCurtainTopLeft', 'blindCurtainTopRight', 'blindCurtainBottomLeft', 'blindCurtainBottomRight', 'blindCurtainSliceBottom', 'blindCurtainSliceTop', 'stampede', 'mosaic', 'mosaicReverse', 'mosaicRandom', 'mosaicSpiral', 'mosaicSpiralReverse', 'topLeftBottomRight', 'bottomRightTopLeft', 'bottomLeftTopRight', 'bottomLeftTopRight'
                                        //you can also use more than one effect, just separate them with commas: 'simpleFade, scrollRight, scrollBottom'
                                        mobileFx			: "simpleFade",	//leave empty if you want to display the same effect on mobile devices and on desktop etc.
                                        gridDifference		: 250,	//to make the grid blocks slower than the slices, this value must be smaller than transPeriod
                                        height				: "44%",	//here you can type pixels (for instance '300px'), a percentage (relative to the width of the slideshow, for instance '50%') or 'auto'
                                        imagePath			: 'images/',	//he path to the image folder (it serves for the blank.gif, when you want to display videos)
                                        hover				: false,	//true, false. Puase on state hover. Not available for mobile devices
                                        loader				: "none",	//pie, bar, none (even if you choose "pie", old browsers like IE8- can't display it... they will display always a loading bar)
                                        loaderColor			: "#eeeeee",
                                        loaderBgColor		: "#222222",
                                        loaderOpacity		: .8,	//0, .1, .2, .3, .4, .5, .6, .7, .8, .9, 1
                                        loaderPadding		: 2,	//how many empty pixels you want to display between the loader and its background
                                        loaderStroke		: 7,	//the thickness both of the pie loader and of the bar loader. Remember: for the pie, the loader thickness must be less than a half of the pie diameter
                                        minHeight			: "132px",	//you can also leave it blank
                                        navigation			: true,	//true or false, to display or not the navigation buttons
                                        navigationHover		: false,	//if true the navigation button (prev, next and play/stop buttons) will be visible on hover state only, if false they will be visible always
                                        mobileNavHover		: false,	//same as above, but only for mobile devices
                                        opacityOnGrid		: false,	//true, false. Decide to apply a fade effect to blocks and slices: if your slideshow is fullscreen or simply big, I recommend to set it false to have a smoother effect
                                        overlayer			: false,	//a layer on the images to prevent the users grab them simply by clicking the right button of their mouse (.camera_overlayer)
                                        pagination			: false,
                                        playPause			: false,	//true or false, to display or not the play/pause buttons
                                        pauseOnClick		: false,	//true, false. It stops the slideshow when you click the sliders.
                                        pieDiameter			: 38,
                                        piePosition			: "rightTop",	//'rightTop', 'leftTop', 'leftBottom', 'rightBottom'
                                        portrait			: true, //true, false. Select true if you don't want that your images are cropped
                                        rows				: 4,
                                        slicedCols			: 6,	//if 0 the same value of cols
                                        slicedRows			: 4,	//if 0 the same value of rows
                                        slideOn				: "next",	//next, prev, random: decide if the transition effect will be applied to the current (prev) or the next slide
                                        thumbnails			: false,
                                        time				: 6000,	//milliseconds between the end of the sliding effect and the start of the nex one
                                        transPeriod			: 1000,	//lenght of the sliding effect in milliseconds
                                        onEndTransition		: function() {  },	//this callback is invoked when the transition effect ends
                                        onLoaded			: function() {  },	//this callback is invoked when the image on a slide has completely loaded
                                        onStartLoading		: function() {  },	//this callback is invoked when the image on a slide start loading
                                        onStartTransition	: function() {  }	//this callback is invoked when the transition effect starts
                                    });
                                });
                            })(jQuery);
                        </script>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>

<?php  endif; ?>


