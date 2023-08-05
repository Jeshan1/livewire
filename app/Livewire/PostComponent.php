<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class PostComponent extends Component
{
    use WithPagination;
    public $isOpen = 0,$id, $title,$description;
    public function create()
    {
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {
        Post::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);
        session()->flash('success','Post created successfully.');
        $this->closeModal();
        $this->reset('title','description');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->title = $post->title;
        $this->description = $post->description;
        $this->id = $post->id;
        $this->openModal();
    }

    public function update()
    {
        $post = Post::findOrFail($this->id);
        $post->update([
            'title'=>$this->title,
            'description'=>$this->description
        ]);

        session()->flash('success','Post Updated Successfully.');
        $this->closeModal();
        $this->reset('title','description','id');

    }

    public function render()
    {
        return view('livewire.post-component',[
            'posts'=>Post::paginate(5)
        ]);
    }

    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('success', 'Post deleted successfully.');
        $this->reset('title','description');
    }
}
