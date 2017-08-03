<?php

use yii\db\Migration;

class m170421_053827_tweet_table extends Migration
{
	public function up() {
		$this->createTable ( 'tweets', [ 
// 		        'id' => $this->bigInteger(32)->notNull (),
                'id' => $this->bigPrimaryKey(),
				'text' => $this->string ( 255 )->notNull (),
				'author_name' => $this->string ( 255 ),
				'author_profile' => $this->string ( 255 ),
				'author_pic' => $this->string ( 255 ) 
		], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' );
		
		
		$this->createTable ( 'users', [ 
// 		        'id' => $this->bigInteger(32)->notNull (),
                'id' => $this->bigPrimaryKey(),
				'name' => $this->string ( 255 )->notNull (),
				'password_hash' => $this->string ( 255 )->notNull (),
				'birth_year' => $this->integer ( 8 ),
				'education' => $this->string ( 255 ),
		        'role'=>$this->string(255)
		], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' );
		
		
		$this->createTable ( 'sentiments', [ 
    		    'id' => $this->bigPrimaryKey(),
				'sentiment' => $this->string ( 255 )->notNull () 
		], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' );
		
		
		$this->createTable ( 'evaluations', [ 
		        'id'=>$this->bigPrimaryKey(),
				'tweet_id' => $this->bigInteger( 32 )->notNull (),
				'user_id' => $this->bigInteger( 32 ),
		        'session' => $this->string(255),
				'sentiment_id' => $this->bigInteger( 32 )->notNull (),
				'is_latvian' => $this->boolean ()->notNull ()->defaultValue ( true ) 
		], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' );
		
// 		$this->addPrimaryKey("tweets_pk", 'tweets', 'id');
// 		$this->addPrimaryKey("users_pk", 'users', 'id');
// 		$this->addPrimaryKey("sentiments_pk", 'sentiments', 'id');
		
		$this->addForeignKey ( "evaluations_tweet_id", "evaluations", [ "tweet_id" ], "tweets", [ "id" ], "CASCADE", "CASCADE" );
		$this->addForeignKey ( "evaluations_user_id", "evaluations", [ "user_id" ], "users", [ "id" ], "CASCADE", "CASCADE" );
		$this->addForeignKey ( "evaluations_sentiment_id", "evaluations", [ "sentiment_id" ], "sentiments", [ "id" ], "CASCADE", "CASCADE" );
		
		$this->batchInsert('sentiments', ['id','sentiment'], [
		    [1, 'Positive'],
		    [2, 'Negative'],
		    [3, 'Neutral'],
		    [4, 'Unknown']
		]);

	}
	
	
	public function down() {
		
	    $this->dropForeignKey("evaluations_sentiment_id", "evaluations");
	    $this->dropForeignKey("evaluations_user_id", "evaluations");
	    $this->dropForeignKey("evaluations_tweet_id", "evaluations");
	    
	    $this->dropTable('tweets');
	    $this->dropTable('users');
	    $this->dropTable('sentiments');
	    $this->dropTable('evaluations');
		
		return true;
	}
}
