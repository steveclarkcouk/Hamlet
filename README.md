# Hamlet
Hamlet is a simple plugin that works with Flamingo and Contact Form 7 that enables you to set a field/checkbox when enabled to only save the data to Flamingo ( this will need rewriting ). Inspired by Tom Wakes blog post - https://blog.strategiq.co/gdpr-compliance-with-contact-form-7-and-flamingo-what-ive-found-so-far-f0aefd0ca91a I thought I would wrap this into a plugin.

## Installation
Download or clone this repo to your computer. Then install it via FTP or through the Wordpress Admin interface.

## Enable
Go to the plugins menu and activate the plugin. 

## Configuration / Setting it up
When you edit any Contact Form 7 form you will be presented with a new tab:
![Image](http://www.clark-studios.co.uk/i/1.png)

Now lets assume we had a form and have Flamingo installed. By default WPCF7 will save all data to Flamingo. In the GDPR age that is a big no no. Now you could use the acceptance field but you are not really supposed to do that plus its pretty bad UX. So we have a contact form but we now want to add a checkbox that when ticked will save the data to Flamingo. So see my example checkbox below:

![Image](http://www.clark-studios.co.uk/i/2.png)

Now go to the Flamingo Options tab and then enter the same field name into the text box.

![Image](http://www.clark-studios.co.uk/i/3.png)

Now when a user checks that box on the front end the form will save to Flamingo, if it is not ticked then it does not and you just get sent an email as per normal. Whola!

Its pretty simple but it may of some use to someone.

### Me
Steve Clark - www.clark-studios.co.uk 



