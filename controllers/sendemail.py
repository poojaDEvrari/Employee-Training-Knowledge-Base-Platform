
import sys

email=""
password=""
username=""
count = 0
for arg in sys.argv:
    if (arg == "-u"):
        username = sys.argv[count+1]
    if (arg == "-p"):
        password = sys.argv[count+1]
    if (arg == "-e"):
        email = sys.argv[count+1]    
    count=count+1
    
def send_email(user, pwd, recipient, subject, body):
    import smtplib
    FROM = user
    TO = recipient if type(recipient) is list else [recipient]
    SUBJECT = subject
    TEXT = body

    # Prepare actual message
    message = """From: %s\nTo: %s\nSubject: %s\n\n%s
    """ % (FROM, ", ".join(TO), SUBJECT, TEXT)
    try:
        server = smtplib.SMTP("smtp.gmail.com", 587)
        server.ehlo()
        server.starttls()
        server.login(user, pwd)
        server.sendmail(FROM, TO, message)
        server.close()
        print ('successfully sent the mail')
    except:
        print ("failed to send mail")
        
send_email("hackscorpionmora@gmail.com","123456mora",email,"TrainMe.lk user account registration","Account Name ="+username+" & Password = "+password)
