<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveStory;
use App\Http\Requests\UpdateStory;

use App\Http\Resources\StoryResource;

use App\Services\StoryService;

use App\Utilities;

class StoryController extends Controller
{
    private $storyService;

    public function __construct()
    {
        $this->storyService = new StoryService;
    }

    public function save(SaveStory $request)
    {
        $data = $request->validated();

        $story = $this->storyService->save($data);

        return Utilities::ok(new StoryResource($story));
    }

    public function update(UpdateStory $request, $storyId)
    {
        if (!is_numeric($storyId) || !ctype_digit($storyId)) return Utilities::error402("Invalid parameter storyId");

        $data = $request->validated();

        $story = $this->storyService->getStory($storyId);
        if(!$story) return Utilities::error402("Story not found");

        $story = $this->storyService->update($data, $story);

        return Utilities::ok(new StoryResource($story));

    }

    public function stories()
    {
        $stories = $this->storyService->getStories();

        return Utilities::ok(StoryResource::collection($stories));
    }

    public function story($storyId)
    {
        if (!is_numeric($storyId) || !ctype_digit($storyId)) return Utilities::error402("Invalid parameter storyId");

        $story = $this->storyService->getStory($storyId);
        if(!$story) return Utilities::error402("Story not found");

        return Utilities::ok(new StoryResource($story));
    }

    public function delete($storyId)
    {
        if (!is_numeric($storyId) || !ctype_digit($storyId)) return Utilities::error402("Invalid parameter storyId");

        if (!is_numeric($storyId) || !ctype_digit($storyId)) return Utilities::error402("Invalid parameter storyId");

        $story = $this->storyService->getStory($storyId);
        if(!$story) return Utilities::error402("Story not found");

        $this->storyService->delete($story);

        return Utilities::okay("Story Deleted");
    }
}
