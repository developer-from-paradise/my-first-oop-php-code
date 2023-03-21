# Doodle Search Engine

This website allows users to retrieve data from Google and generate chat responses with an AI model called ChatGPT.

# Usage

1. Clone the repository to your local machine.
2. Create openAI account, Google Cloud Account, rapidapi.com and SQL Database.
3. Get your Google API credentials, ChatGPT token, rapid api token and SQL datas. The following variables must be filled in config file:

```
client_id          = <your google client id>
client_secret      = <your google client_secret here>
apiGPT             = <your openAi token here>
apiGoogle          = <here is your rapidapi key>
db_host, db_user.. = <your db creditions>
```

4. Import sql file into your mysql database
5. Run the server apache2.
6. Navigate to `http://localhost/` in your browser.
7. Login using Google account".
8. Make a query into search input

## Dependencies

This website uses the following dependencies:

- `googleapis` For authorization user
- `Open AI ChatGPT token` For making requets to chatGPT
- `Rapid api` For getting article of google
- `SQL Database` For storing data

## Demo version

I installed this project into a hosting here is a link
[Demo link](http://f0792778.xsph.ru/doodle/)