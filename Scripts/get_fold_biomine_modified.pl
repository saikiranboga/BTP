#!/usr/bin/perl
$| = 1;
use strict;
use Data::Dumper;
use LWP;
use FileHandle;

#http://biomine.ece.ualberta.ca/1D/Processing.asp
#seq=$fasta
#seqFormatted=$seq
#methods=Fold
#149     Cluster39412    HGT_ORFM384032  115     >HGT_ORFM384032|BABC01004093|357-704|-|complete MKQLRARKQRIVAREYAKARKRRTYLIIRL

my $browser = LWP::UserAgent->new;
chomp(my $infile=$ARGV[0]);
my $outfile=$infile."_fold_biomine";
open(IN,"$infile") or die $!;
open(OUT,">$outfile") or die $!;
my $count=0;
open(LOG,">server.log") or die $!;

$browser->timeout(400);
LOG->autoflush(1);
OUT->autoflush(1);

while(chomp(my $line=<IN>))
{
  my ($query,$annot,$seq);
  if ($line =~ /^>/)
  {
  	$annot=$line;
	chomp(my $line=<IN>);
	$seq=$line;
	$seq=~s/\*$//;
  }
  #my @arr=split(/\t/,$line);
  #$annot=$arr[2];
  #$seq=$arr[5];
  $count++;
  $query="$annot\n$seq";
  #$query=">$annot\n$seq";
  #print $query,"\n";
  #exit;
  my $url = 'http://biomine.ece.ualberta.ca/1D/Processing.asp';
  my $response;
  print LOG "$annot\n";
  do
  {
    $response = $browser->post( $url, [ 'mode' =>'string' , 'seq' => $query, 'seqFormatted' => $seq , 'methods' => 'All']);
    print  LOG "-- ", $response->status_line , "\n";
	print $response->status_line , "\n";
  }while(!$response->is_success);
  
  if( $response->content =~ m/\/1D\/results\/\d+\/html\/results\.csv/ ) 
  {
     my $resurl;
	 $resurl="http://biomine.ece.ualberta.ca" . $&;
     my $result;
     do
     {
     	$result = $browser->get( $resurl);
     	print LOG "-- ", $result->status_line ,"\n";
     	print  $result->status_line ,"\n";	
     }while(!$result->is_success);
     
     my @csv= split(",",$result->content);
     my $fold=$csv[11].":".$csv[15];
     #print Dumper($result),"\n";
     print OUT "$annot\n$seq\n$fold\n";
     #print "$fold\t$line\n";
     
  }  
  else 
  {
     print OUT "$annot\n$seq\nNA\n";
  }

}
close(IN);
close(OUT);
close(LOG);
print "Total $count seq submitted\n";
exit;

