$formatter = new Java('java.text.SimpleDateFormat',
                     "EEEE, MMMM dd, yyyy 'at' h:mm:ss a zzzz");

print $formatter->format(new Java('java.util.Date'));
