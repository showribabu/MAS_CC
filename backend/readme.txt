server_param will generate server parameter like q,s,gpk,p,kv,r and store it all in server_param table.
[all value are in decimal form]

for time being:
id_gen will generate x, u, unew and store it in groupdata table.
all value are first generated as decimal  value then it is converted to string then it is hashed, then output hexadecimal value is converted to decimal form 

till now:-
q,s,gpk,p,kv, r are all generated and stored in server_param table
x, u, unew are generated and stored in groupdata table.

now using db.php we get all values then do calculatino for adminId, groupId, memberVerifier and store back the result in groupdata table.



