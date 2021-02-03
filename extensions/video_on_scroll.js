jQuery(function () {
  jQuery(".vx-vos").each(function(index){
    var video = null;
    var wrapper = this;

    var data = {
      index: index,
      tweenedValue: 0,
      currentValue: 0,
      duration: 0,
      settings: {
        distance: 1000,
        offset: 0.5,
        smoothingTime: 350,
        refreshRate: 50
      }
    }

    if(jQuery(this).attr('data-vos_distance') && jQuery(this).attr('data-vos_distance_unit')){
      data.settings.distance = jQuery(this).attr('data-vos_distance');
      if(jQuery(this).attr('data-vos_distance_unit') == "%"){
        data.settings.distance =  jQuery(this).outerHeight() / (100 / jQuery(this).attr('data-vos_distance'));
        console.log("The distance from % in PX is: " + data.settings.distance);
      } else {
        console.log("The distance in PX is: " + data.settings.distance);
      }
    }
    if(jQuery(this).attr('data-vos_screenoffset')){
      data.settings.offset =  jQuery(this).attr('data-vos_screenoffset') / 100;
    }
    if(jQuery(this).attr('data-vos_smoothingTime')){
      data.settings.smoothingTime =  jQuery(this).attr('data-vos_smoothingTime');
    }
    if(jQuery(this).attr('data-vos_refreshRate')){
      data.settings.refreshRate =  jQuery(this).attr('data-vos_refreshRate');
    }
    console.log(  );

    if(data.settings.smoothingTime != 0){
      var intervalId = window.setInterval(function(){ // Refresh Scroll and Smooth it over time..
        gsap.to(data, {
          duration: data.settings.smoothingTime / 1000,
          tweenedValue: data.currentValue
        }); // something like this?
      }, data.settings.smoothingTime);


      var intervalId = window.setInterval(function(){ // Refresh video
        if(video != null){
          video.currentTime = data.duration * data.tweenedValue;
        }
      }, data.settings.refreshRate);
    }


    if(jQuery(this).find('video.elementor-background-video-hosted')[0] != undefined){
      video = jQuery(this).find('video.elementor-background-video-hosted')[0]
    }
    var canplayOnce = false;
    video.addEventListener('canplay', (event) => {
      if(canplayOnce){ return }
      canplayOnce = true;
      console.log('Video can start, stop it now!');
      video.pause();
      video.currentTime = 0;
      var pointer = Math.ceil(window.innerHeight * data.settings.offset);
      // Here the magic happens 🧙‍♂️

      data.duration = video.duration;
      var duration = video.duration;

      document.addEventListener ('scroll',function () {
        var scroll = wrapper.getBoundingClientRect().top - pointer;
        var mover = Math.abs(clamp(scroll, -data.settings.distance, 0) / data.settings.distance); // We need to smooth that shit 🍮
        data.currentValue = mover;
        if(data.settings.smoothingTime == 0){
          video.currentTime = duration * mover;
        }
      });

    });
  });
});
function clamp(num, min, max) {
  return num <= min ? min : num >= max ? max : num;
}
