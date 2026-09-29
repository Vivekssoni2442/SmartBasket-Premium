# TODO — AI Camera Assistant: Make all buttons fully functional

## 1. Backend structure
- [ ] Create `app/Services/VirtualTryOnService.php` (provider-agnostic composite processing, future AI-model hook)
- [ ] Add `result_image` column migration for `ai_camera_histories`

## 2. Controller + Model
- [ ] Update `app/Http/Controllers/AICameraAssistantController.php` (processVirtualTryOn, resultImage methods; save source + result to history)
- [ ] Update `app/Models/AICameraHistory.php` (fillable result_image)

## 3. Routes
- [ ] Add `POST /ai-camera-assistant/virtual-try-on` and `GET /ai-camera-assistant/result/{file}` in `routes/web.php`

## 4. Frontend (JS + views + CSS)
- [ ] Update `public/js/ai-camera-assistant.js` (Virtual Try-On submit→loading→render result; Download PNG/JPG; Share image file; History shows images)
- [ ] Update `public/css/ai-camera-assistant.css` (result image style - no redesign)
- [ ] Update `resources/views/ai-hub/camera-assistant.blade.php` (result render area)
- [ ] Update `resources/views/ai-hub/sidebar/camera-assistant.blade.php` (result render area)

## 5. Verify
- [ ] Run `php artisan migrate`
- [ ] Run feature tests

