<?php

namespace App\Services;

use App\Models\Story;

class StoryService
{
    public function save($data)
    {
        $story = new Story;
        $story->title = $data['title'];    
        $story->content = $data['content'];
        $story->date = $data['date'];
        $story->save();

        return $story;
    }

    public function update($data, $story)
    {
        if(isset($data['title'])) $story->title = $data['title'];    
        if(isset($data['content'])) $story->content = $data['content'];
        if(isset($data['date'])) $story->date = $data['date'];
        $story->update();

        return $story;
    }

    public function getStories()
    {
        return Story::orderBy("created_at", "DESC")->get();
    }

    public function getStory($storyId)
    {
        return Story::find($storyId);
    }

    public function delete($story)
    {
        $story->delete();
    }
}