#!/usr/bin/perl -w

use strict;

use Email::Sender::Simple qw(sendmail);
use Email::Sender::Transport::SMTP::TLS;
use Try::Tiny;

my $To = $ARGV[0];
my $Query = $ARGV[1];
my $Subject = "MetaGen Query Results";
my $Body = "<html><p>Query id= $Query, has been processed.<br/>You can get result on following link: <br/><a href=\"http://localhost/ShowResult.php?q=$Query\">Query Result</a>: http://localhost/ShowResult.php?q=$Query<br/></p></html>";

print $To . "\n";

my $transport = Email::Sender::Transport::SMTP::TLS->new(
    host => 'smtp.gmail.com',
    port => 587,
    username => 'metagen.noreply@gmail.com',
    password => 'metagennoreply',
    helo => 'MetaGen',
    );

# my $message = Mail::Message->read($rfc822)
#         || Email::Simple->new($rfc822)
#         || Mail::Internet->new([split /\n/, $rfc822])
#         || ...
#         || $rfc822;
# read L<Email::Abstract> for more details

# if email body is HTML - set content type, otherwise make TEXT
#my $email_type = ($Body eq 'HTML' ? 'text/html' : 'TEXT');
my $email_type = 'text/html';

use Email::Simple::Creator; # or other Email::
my $message = Email::Simple->create(
    header => [
	From    => '"MetaGen" <metagen.noreply@gmail.com>',
	To      => $To,
	Subject => $Subject,
	'Content-Type' => 'text/html',
    ],
    body => $Body,
    );

try {
    sendmail($message, { transport => $transport });
    print "trying...\n";
} catch {
    die "Error sending email: $_";
};

# use Net::SMTP::TLS;

# #Send Mail

#     my $smtp = Net::SMTP::TLS->new(
# 	Host => 'smtp.gmail.com',
# 	Hello => 'metagen.noreply@gmail.com',
# 	Port => 587,
# 	User => 'metagen.noreply@gmail.com',
# 	Password => 'metagennoreply',
#     );

# $smtp->mail($To);

