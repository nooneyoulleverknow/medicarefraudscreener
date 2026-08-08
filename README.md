# medicarefraudscreener
just some scripts to chop up the medicaid files, so that you can search by various criteria.

There are 3 main scripts, but don't run them yet.
1. makestatehash.php
2. medicaidmakebills.php
3. evaluator.php
These will all be in the main playing area, whether it be your desktop or somewhere else you choose.
These should not be ran as webpage on a webserver.  Instead they should be ran as php client
That is, from a terminal you would type php makestatehash.php


Now before you get started....
you have to download some mega files
1.  https://download.cms.gov/nppes/NPPES_Data_Dissemination_July_2026_V2.zip
2.  https://opendata.hhs.gov/datasets/medicaid-provider-spending/
These should go in your workspace folder, and you should do so now and decompress
When you are done, this should occupy between 20-25 GB.

Now you could get the latest NPPES data, and that would result in a name change and would break the code....
But a simple fix without changing code is to ensure that the nppes folder is named:
NPPES_Data_Dissemination_April_2026_V2
and make sure the 10GB file inside is called:
npidata_pfile_20050523-20260412.csv

Of course, DHHS could change the file structure in the future possibly breaking everything, so the April 2026 edition is known to be compatible with the code anyways.

OK, so at this point I am going to assume you downloaded the client, and downloaded and exacted the files.
The next stop will be to populate the medicaid_files folder.

To speed things up, a hashtable was required.  The hashtable was over 300MB and the github limit, so sadly we have to recreating it.
So from the command line, change directory into to your play area
then type:

php makestatehash.php

On a newer $500 machine with 32GB Ram, and an SSD drive, it takes about 4 minutes.  If you don't have php installed, and you are on linux, you might want to try:
sudo apt install php

If you are on windows, I mean you still could install php.  But maybe it's time to leave microsoft behind.

So you should have a file in the medicaid_files called:
npidata_pfile_20050523-20260412.ser

If you don't,
make sure you have the files:
[play area]/workspace/medicaid-provider-spending.csv
[play area]/workspace/NPPES_Data_Dissemination_April_2026_V2/npidata_pfile_20050523-20260412.csv
and that the php script ran (it should show a percent complete, time ran, estimated time total, and how far into memory it is reading)

ok, assuming everything works...well before trying
This is probably going to take at least 8 hours on an ssd drive.  So you may want to run this script when you are asleep.  If you are going to leave it running in an office, make sure that the office still has power after hours.  If you were trying it on my 15 year old laptop, not that I tried, I gasp to think this could take a week or two...maybe more.
so, oh year,  by the time we are done, the medicaid_files folder will take up about 170GB or more.
Why?  IDK, but this will chop up the bulk medicaid datadump and divide it p into 2 separate chunks by state.  One by the billers, and the other by the servicers.  It will also join the npped data.  So it will be faster in analyzing a particular state
So assuming your system can handle it, try:
php medicaidmakebills.php

after it is complete, assuming it doesn't break, you will have more than 100 files in the medicaid_files folder, including US territories

Now the evaluator is simple yet complicated.
It will take between 7 and 9 parameters.
It was initially build around a statistical analysis, so it isn't that bad to figure out.
After that was completed, the next state was to add enhanced filtering so you could look by say a town, a zip code, or area code.  It's possible you can search by multiple filters at a term so long as it is delimited by a colon, but I haven't tested it in months to be sure.
After that was completed, I wasn't really getting the hits I wanted.  So then I decided to make a first name database.  There were a lot of errors at first, but in fixing medicaidmakebills.php most of the anomalies went away.
During this time, I learned that a federal judge, whom I said in motion should have been impeached 10 years ago, in my old case committed a fraud in the court.  So I had to file a rule 60(d)(3) to reopen the civil case in a timely manner and recuse the judge.  On top of this I filed a bar complaint seeking to disbar a federal judge (yes there is precedent), and filed a rule change petition.  The GA Bar decided to cover for the federal judge, and so I had to seek review from the GA supreme court.  So needless to say instead of swiftly finishing the project, I files 3 legal actions in court.
Finally, I decided to add an aggregator.  Wasn't sure where to put it in, just I was getting tired for a long time seeing repeated entries but someone billing weekly or something.

So let's say we want to search maine, based upon the service providers, in the year 2024, with a standard deviation of 2 as applied to revenue, against all billing codes:
php evaluator.php me s 2024 all 2 revenue

Now let's say that I want to search both maine and minnesota, for service providers (I haven't found billers useful), for all years, for covid, with a standard deviation of 0 to show all records, against revenues per client:
php evaluator.php me:mn s all code:covid 0 revenueperclient

Oh yea bummer.  The covid stuff is in the cpt and hcpcs I data that is copyrighted from the AMA.  So I can't give you a copy of the description for the codes are, HCPCS II codes are supposedly public domain and you got those.  If you are interested in covid billings, ask AI what cpt and HCPCS I codes cover covid then assign the values in the quotes (after the billing code) in /data/cptdictionary2.

So let's cover these basic arguments.
The first is the state.  And as you can see, you can use multiple states at the same time by placing a colon between them.  There might be an "all" option, but I haven't tested it.

the second argument is whether you want a servicer (s), or a biller (b), or both (all).  TBH, I haven't tried all.

The third argument is the year, which can be anywhere from 2018-2026.  As seen above you can use all.  I am unsure if I created the ability to use color delimiters.  It's stuff I write before the recent dishoborable judge Eleanor Ross mess, the documentation says you can use colon delimiters, and there appears to be code that says you can.

The fourth argument is the billing code.  You can use "all" and it will use all known codes, you can use code:[search term] that will use the codes whose description has that term, you can use a colon delimiter, and I thinkyou can just use the first Letter [or number] of a code to get the result series.  for example the HCPCS codes typically are broken in into categories of related matters, and are assigned a Letter as the first digit in the code.

The 5th argument is the standard deviation.  Setting the standard deviation to 0 will show all results.  Setting a standard deviation to 2, should, in theory, eliminate 95% of the results.  This can be a powerful tool to detect fraud, but mind you a hospital that deals with high needs inmates will tend to have more billable hours per patient than a ore stable client who might go ones a week or month.

The 6th argument asks what type of measure we are using.  We only check one field at a time even if they are hybred fields.
These options are:
clients/revenue/address/phone/first:last/fax/organization
although it should be noted that not all of these have been tested



Now let's suppose I just want to focus on the town of lewiston as to the billing code t2016
php evaluator.php me s all code:covid 0 revenueperclient match lewiston city 

Let's suppose an out of state zipcode
php evaluator.php me s all code:covid 0 revenueperclient !match zip

There is no point really to give multiple examples of this

The 7th argument is match, match all, or !match.
Many of the fields in the data have 2-3 items for which we parsed, there may be dozens of them in the original data.  Often they are blank.  So match basically ask per line item, is there to least one that matches this request.

matchall is a bit decieving.  It will try to find a match on all the fields, but it will treat empty fields as a positive.  So a record that is completely void of information is still registered as a match.

!match is effectively no matches.  

the 8th argument is the type of field we are looking for:
areacode
zipcode
nameorigin
term
term1:term2

Again this was made before the Ross mess.
My Understanding is you can use say zipcode or area code as the 8th element.  nameorigin will require a region code as the 9th element.

region code:
eu,in,is,su,na,aa,af,jp,bm,oc,kr,ru,hs,th,cb,ch
they can even be combined like af:su
af would include african names and arabic names, su would be susa (persia), aa is african america, na is north american (but the ai liked to put in non applicable into the na region)

A term in the 8th argument as seen above is a query term, like lewiston. it should have a matching 9th argument like city as seen above. you can chain them above live 75:lewiston as the 8th argument and address:city as the 9th argment.  The number of delimiter must match if you do a search this way.  
the searchable fields in argument 9 are
city
state
lname
fname
address
ein
npi
title
organization

The last variant tried to aggregate data.
I was uncertain how to implement this, but for now I took the most basic model and allowed a 7th argument of company or address.  here is for company, it will reduce some redundancy from a traditional table view.
php evaluator.php me s all code:covid 0 revenue city

The below might be useful to try to identify if a bunch of payments are going to one address
php evaluator.php me s all code:covid 0 revenue address
But it should be noted, that all other information other then the financials, will be based upon initial values.  so if you have 50 businesses in one street address, you will only see the first business it saw [for that year].  This view doesn't care what the others are

more aggragates can be added with ease if you are competent.  just open up evaluator.php and search for "company". It should appear in 4 locations.  pretty much copy paste, change the new "company" to a serahc term of your desire, and change the values found in list.


additional files
1.namedictionary2
2.cptdictionary2
3.hcpcsdictionary2
4.zipcodes
5.areacodes

these are just csv or comma delimited files.
