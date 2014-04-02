#162     HGT_ORFM395021  >ORFM395021|BABC01009931|393-938|-|complete     MDSNSAPFFRVKVGCVDSVPRAVLPWVLASWIDKPTERREEPMTRSVEEQMADIERRTKQLRARKQRIV

use strict;
use LWP;
use FileHandle;  
#149     Cluster39412    HGT_ORFM384032  115     >HGT_ORFM384032|BABC01004093|357-704|-|complete MKQLRARKQRIVAREYAKARKR
#http://www.csbio.sjtu.edu.cn/cgi-bin/PFPPred.cgi
#flush output  buffer
$|=1; 
my $browser = LWP::UserAgent->new;
chomp(my $infile=$ARGV[0]);
my $outfile=$infile."_PFPPred_fold";
open(IN,"$infile") or die $!;
open(OUT,">$outfile") or die $!;
open(LOG,">server.log") or die $!;
$browser->timeout(400);
LOG->autoflush(1);
OUT->autoflush(1);

my $count=0;
while(chomp(my $line=<IN>))
{
  my ($query,$seq);
  if ($line =~ /^>/)
  {
  	$query=$line;
	chomp(my $line=<IN>);
	$seq=$line;
	$seq=~s/\*$//;
  }
  
  #my @arr=split(/\t/,$line);
  #$query=$arr[2];
  #$seq=$arr[5];
  $count++;
# print "$query\t$seq\n";
# exit;
  my $url = 'http://www.csbio.sjtu.edu.cn/cgi-bin/PFPPred.cgi';
  my $response = $browser->post( $url, [ 'mode' =>'string' , 'S1' => $seq ]);
  my $log_count=0;
  do{
  	if($response->status_line ne "200 OK")
	{
		if($log_count==0)
		{
			print LOG  "$query: ", $response->status_line ,"\n", $response->as_string ,"\n";
		}
	} 
	$log_count++;
    }while(!$response->is_success);
  
  #print $response->content ;
  if( $response->content =~ m/'#5712A3'\s+face='times new roman'>(.*?)<\/font?>/g ) 
  {
  	my $fold=$1;
	print "$fold\n";	
	print OUT "$query\n$seq\n$fold\n";
  }  
  else 
  {
  	print OUT  "$query\n$seq\nNA\n";
  }

}

close(IN);
close(OUT);
close(LOG);
print "Total $count seq submitted\n";
exit;

