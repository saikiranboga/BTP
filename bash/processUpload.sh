#!/bin/bash
query=$1
to=$2
/home/vivek/BTP/blast+/bin/blastp -query uploads/$query -db /home/vivek/BTP/blast+/db/unannotated.fasta -outfmt 5 -num_threads 4 > results/${query}.out
./Scripts/sendMail.pl $to $query >> logs/sendMailPerl.log