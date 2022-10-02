<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * 将请求中的某些字段包含的base64转换为图片保存
 * 作用：防止数据库保存时超长报错
 */
class ConvertBase64ToImage
{
    const need_convert_fields = ['content', 'description'];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach (self::need_convert_fields as $field) {
            if ($request->has($field) && is_string($request->input($field))) {
                $newValue = $this->convertBase64ToImage($request->get($field));
                $request->request->set($field, $newValue);
            }
        }

        return $next($request);
    }

    /**
     * 将请求中的base64转换为图片保存，返回替换之后的内容
     * @param $content
     * @return string
     */
    protected function convertBase64ToImage($content): string
    {
        $regx = '/src="(data:image\/[^;]+;base64[^"]+)"/i';
        if (preg_match_all($regx, $content, $match)) {
            $dataImage = $match[1];
            foreach ($dataImage as $item) {
                $imageUrl = $this->saveBase64ToFile($item);
                $content = str_replace($item, $imageUrl, $content);
            }
        }
        return $content;
    }

    /**
     * @param $base64Code
     * @return string
     */
    protected function saveBase64ToFile($base64Code): string
    {
        $image = explode(',', $base64Code);
        // 图片扩展名
        preg_match('/data:image\/(\w+);base64/', $image[0], $imageMatch);
        $imageExt = $imageMatch[1];
        $imageCode = $image[1];
        // 保存文件
        $fileName = Str::uuid()->getHex() . '.' . $imageExt;
        $savePath = substr($fileName, 0, 2) . '/' . substr($fileName, 2, 2) . '/' . $fileName;
        Storage::disk('images')->put($savePath, base64_decode($imageCode));
        return config('filesystems.disks.images.url') . '/' . $savePath;
    }
}
