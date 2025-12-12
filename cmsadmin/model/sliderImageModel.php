<?php
class sliderImage implements JsonSerializable {
    private $imageFileId;
    private $image;
    private $ImageFileCaption;
    private $ImageAlternateText;
    private $createdby;
    private $createon;
    private $modifiedby;
    private $modifedon;
    private $postId;  // 🔹 New property
    private $fileType;
    private $videoUrl;
    private $videoFile;

    public function getFileType() { return $this->fileType; }
    public function setFileType($fileType) { $this->fileType = $fileType; return $this; }

    public function getVideoUrl() { return $this->videoUrl; }
    public function setVideoUrl($videoUrl) { $this->videoUrl = $videoUrl; return $this; }

    public function getVideoFile() { return $this->videoFile; }
    public function setVideoFile($videoFile) { $this->videoFile = $videoFile; return $this; }

    // ---------- ID ----------
    public function getImageFileId() { return $this->imageFileId; }
    public function setImageFileId($imageFileId) { $this->imageFileId = $imageFileId; return $this; }

    // ---------- Image ----------
    public function getImage() { return $this->image; }
    public function setImage($image) { $this->image = $image; return $this; }

    // ---------- Caption ----------
    public function getImageFileCaption() { return $this->ImageFileCaption; }
    public function setImageFileCaption($ImageFileCaption) { $this->ImageFileCaption = $ImageFileCaption; return $this; }

    // ---------- Alternate Text ----------
    public function getImageAlternateText() { return $this->ImageAlternateText; }
    public function setImageAlternateText($ImageAlternateText) { $this->ImageAlternateText = $ImageAlternateText; return $this; }

    // ---------- Created By ----------
    public function getCreatedby() { return $this->createdby; }
    public function setCreatedby($createdby) { $this->createdby = $createdby; return $this; }

    // ---------- Created On ----------
    public function getCreateon() { return $this->createon; }
    public function setCreateon($createon) { $this->createon = $createon; return $this; }

    // ---------- Modified By ----------
    public function getModifiedby() { return $this->modifiedby; }
    public function setModifiedby($modifiedby) { $this->modifiedby = $modifiedby; return $this; }

    // ---------- Modified On ----------
    public function getModifedon() { return $this->modifedon; }
    public function setModifedon($modifedon) { $this->modifedon = $modifedon; return $this; }

    // ---------- Post ID ----------
    public function getPostId() { return $this->postId; }
    public function setPostId($postId) { $this->postId = $postId; return $this; }

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'ImageFileId' => $this->imageFileId,
            'ImageFilePath' => $this->image,
            'ImageFileCaption' => $this->ImageFileCaption,
            'ImageAlternateText' => $this->ImageAlternateText,
            'modifiedby' => $this->modifiedby,
            'createdby' => $this->createdby,
            'createon' => $this->createon,
            'modifedon' => $this->modifedon,
            'postId' => $this->postId,   // 🔹 Added in JSON
            'fileType' => $this->fileType,
            'videoUrl' => $this->videoUrl,
            'videoFile' => $this->videoFile,

        ];
    }
}
?>
