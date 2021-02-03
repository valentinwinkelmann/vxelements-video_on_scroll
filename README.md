
## VXElements - Video On Scroll
This extension adds a useful feature to Elementor that allows you to create cool and stylish on-scroll animations for video backgrounds.
You probably know such effects from the [Apple Airpod Page](https://www.apple.com/de/airpods-pro/).
#### ⁉What exactly does this plugin do?
The plugin extends the Elementor section and adds a new option to the section element under the "Advanced" tab. There you can activate the video on scroll function with just one mouse click.
## 🔌Requirements

You only need Elementor to use the extension. You should also have a video in a suitable format for scrubbing.

## 📃How to Use
Just download the plugin ZIP file under "Release" and install it in WordPress. The plugin will work immediately after activation.

To create an on-scroll video element you just need to create a section in Elementor and give it a video background. Then select the "On Scroll Video" section under the "Advanced" tab and activate it. And that's it. You now have a super stylish on-scroll video.
## 📼Video Format
Not every video format is suitable for scrubbing. Therefore a video must first be converted so that it can be scrubbed smoothly without stuttering.

This is relatively simple and can be done with ffmpeg using:
`ffmpeg -i input.mp4 -g 10 output.mp4`

## 🛑Limitations

 - Currently, the whole thing works only on sections that use a video as background. I have not yet implemented a function that allows to use the whole thing on normal video elements.
 - If you activate the sticky option under MotionEffects the video will not play.
 - The whole thing works only with videos, not with JPEG sequences, I will update this in the future.
 - I currently have no idea how well or poorly the whole thing works on mobiles. i recommend disabling it on mobiles.

## 🐞Bug reports and Features Requests
If you find bugs or have questions, feel free to post it in the issue section, that's what it's there for, i'll try to fix the bugs and answer questions. basically the plugin should be self-explanatory though,

## 🗒Note
I designed the whole plugin for one of my clients, I thought it was cool and I thought I'd make an Elementor extension out of it. I can not guarantee that I will always keep the plugin up to date, but I try to do my best.

[You are welcome to support the development with donations.](https://www.paypal.com/donate?hosted_button_id=7TW8RQQ73N8PQ)
## 🏛Disclaimer 
I take absolutely no responsibility for the security and the actuality of the code. Use it at your own risk.
