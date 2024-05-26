<?php

namespace Awcodes\Typist\Concerns;

use Closure;

trait InteractsWithMedia
{
    protected ?array $acceptedFileTypes = null;

    protected string | Closure | null $directory = null;

    protected string | Closure | null $disk = null;

    protected string | Closure | null $imageCropAspectRatio = null;

    protected string | Closure | null $imageResizeMode = null;

    protected string | Closure | null $imageResizeTargetHeight = null;

    protected string | Closure | null $imageResizeTargetWidth = null;

    protected int | Closure | null $maxSize = null;

    protected int | Closure | null $minSize = null;

    protected bool | Closure | null $relativePaths = null;

    protected bool | Closure | null $shouldPreserveFileNames = null;

    protected string | Closure | null $visibility = null;

    public function acceptedFileTypes(array $acceptedFileTypes): static
    {
        $this->acceptedFileTypes = $acceptedFileTypes;

        return $this;
    }

    public function directory(string | Closure $directory): static
    {
        $this->directory = $directory;

        return $this;
    }

    public function disk(string | Closure $disk): static
    {
        $this->disk = $disk;

        return $this;
    }

    public function imageCropAspectRatio(string | Closure | null $ratio): static
    {
        $this->imageCropAspectRatio = $ratio;

        return $this;
    }

    public function imageResizeMode(string | Closure | null $mode): static
    {
        $this->imageResizeMode = $mode;

        return $this;
    }

    public function imageResizeTargetHeight(string | Closure | null $height): static
    {
        $this->imageResizeTargetHeight = $height;

        return $this;
    }

    public function imageResizeTargetWidth(string | Closure | null $width): static
    {
        $this->imageResizeTargetWidth = $width;

        return $this;
    }

    public function maxSize(int | Closure $size): static
    {
        $this->maxSize = $size;

        return $this;
    }

    public function minSize(int | Closure $size): static
    {
        $this->minSize = $size;

        return $this;
    }

    public function preserveFileNames(bool | Closure $shouldPreserveFileNames): static
    {
        $this->shouldPreserveFileNames = $shouldPreserveFileNames;

        return $this;
    }

    public function visibility(string | Closure $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function relativePaths(array | Closure $relativePaths): static
    {
        $this->relativePaths = $relativePaths;

        return $this;
    }

    public function useRelativePaths(): bool
    {
        return $this->evaluate($this->relativePaths) ?? false;
    }

    public function getAcceptedFileTypes(): array
    {
        return $this->acceptedFileTypes ?? config('typist.media.accepted_file_types');
    }

    public function getDirectory(): string
    {
        return $this->directory ? $this->evaluate($this->directory) : config('typist.media.directory');
    }

    public function getDisk(): string
    {
        return $this->disk ? $this->evaluate($this->disk) : config('typist.media.disk');
    }

    public function getImageCropAspectRatio(): ?string
    {
        return $this->evaluate($this->imageCropAspectRatio) ?? config('typist.media.image_crop_aspect_ratio');
    }

    public function getImageResizeMode(): ?string
    {
        return $this->evaluate($this->imageResizeMode) ?? config('typist.media.image_resize_mode');
    }

    public function getImageResizeTargetHeight(): ?string
    {
        return $this->evaluate($this->imageResizeTargetHeight) ?? config('typist.media.image_resize_target_height');
    }

    public function getImageResizeTargetWidth(): ?string
    {
        return $this->evaluate($this->imageResizeTargetWidth) ?? config('typist.media.image_resize_target_width');
    }

    public function getMaxSize(): int
    {
        return $this->evaluate($this->maxSize) ?? config('typist.media.max_size');
    }

    public function getMinSize(): int
    {
        return $this->evaluate($this->minSize) ?? config('typist.media.min_size');
    }

    public function getVisibility(): string
    {
        return $this->visibility ? $this->evaluate($this->visibility) : config('typist.media.visibility');
    }

    public function shouldPreserveFileNames(): bool
    {
        return $this->shouldPreserveFileNames ? $this->evaluate($this->shouldPreserveFileNames) : config('typist.media.preserve_file_names');
    }
}
