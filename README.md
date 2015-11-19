# PhP-Project
My PhP Project repository.

#####Live: http://martin-viktor-arvidsson.se/PHP-project-3x3-5x5-master/Project/Index.php
#Vision

My initial thoughts is to create a web based version of Tic-Tac-Toe(Luffarshack),I have yet to decide if i want it to be playable over the internet(share a URL beween 2 persons and they share the same game session)

Or if i just want to host it online and you will play it locally(Take turns playing 1,2,1,2,1,2....)

I plan on being done with the gamelogic at the end of this week(42), this leaves me with around one week to figure out if i want to play it over internet. 
The biggest problem with this is that i have more or less no idea of how to play it over internet with a shared URL.
This will therefore be work in progress that i will look at when all other things work.

#Use cases
##Mandatory
1. Navigate to page
2. Able to start a new game of tic-tac-toe 3x3 or 5x5
3. Able to play the version of tic-tac-toe locally between two players.
4. Able to place a marker // Not place a marker at already played position on the board.
5. Able to win a game
6. Able to cancel a series
7. Able to win a series
8. not being able to play markers on the board that shows when a player won something.
9. Score is visible on startpage.
10. Score updates accordingly to winning.

#Testcases

| Testcase      |Requirement    | Goal   |Method of testing   | Status |
| ------------- |:------:| -----:| ----------:| ------:|
| Gamelogic | Able to place brick/Marker | saved marker after pressed play | Choose marker, then press play | Done |
| Gamelogic | Able to not place marker on already played position | not being able to place on already played position | Try press where marker is already placed no marker should be placed | Done |
| Gamelogic   | Able to win by tic-tac-toe pattern | Able to win by tic-tac-toe pattern | By Putting three or five depending on gamemode of the same marker in a line and get a Player "" Won this round| Done |
| Gamelogic | Able to cancel a game series | game series cancles when button to cancel is pressed | Start 3x3 or 5x5 press cancel button and get back to start | Done |
| Datahandling   | After winning 3 games in a FT3 series you should win the series | Win series if wins = 3 | Play the 3x3 gamemode| Done |
| Datahandling   | After winning 5 games in a FT5 series you should win the series | Win series if playerwins = 5 | Play the 5x5gamemode | Done |
| Datahandling | After winning a series the score on the startpage should reflect that a player won and update accordingly| Updated score on startpage | Win series | Done |





#How it ended up / Reflection:

The entire application took a lot longer to write than what i had anticipated and accounted for, writing the game and following the MVC structure took a lot more thinking and deciding on how i would write it.

When i got up and running and started programming i realised that i needed a lot of sessions since more or less everything i do caused variables to reset.. I realise in hindsight that i could have structured how i would handle the data a lot better now that i look back.

My schedule wasn't really matching with reality, i planned on working with gamelogic one week and making the game work online the second week. In reality i sat with the gamelogic for 10 days, i did not have time to peform online games as i had wanted , nor did i had any time to implement AI instead. So instead i made only two gamemodes, First to 3 and First to 5 wins.


I also felt that my usecases weren't really where i wanted to have them in quality and quantity, so in hindsight i added a few more.



Other than that i feel like i somewhat made what i had planned, it's a tic-tac-toe game and you can play it locally.
If i had had more time over, i would have done some CSS aswell, at the moment the website doesn't really look that good.



Other than that i feel like i somewhat made what i had planned, it's a tic-tac-toe game and you can play it locally.
If i had had more time over, i would have done some CSS aswell, at the moment the website doesn't really look that good.

