#!/bin/bash
query=$1
sleep 10
/home/vivek/BTP/blast+/bin/blastp -query uploads/$query -db /home/vivek/BTP/blast+/db/unannotated.fasta -outfmt 5 -num_threads 4 > results/${query}.out
