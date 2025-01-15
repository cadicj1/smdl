<?php
namespace App\Jobs;

use App\Models\BasketItems;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Mockery\Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class SubscriptionOrder implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $basketItem;
    /**
     * Create a new job instance.
     */
    public function __construct(Order  $order , BasketItems $basketItems )
    {
        $this->order = $order;
        $this->basketItem = $basketItems;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('Starting subscription processing', [
            'order_id' => $this->order->id,
            'item_name' => $this->basketItem->name]);

        try{

            Log::info('Processing subscription for order', ['order_id' => $this->order->id]);

            $response = Http::post('https://run.mocky.io/v3/30dd1995-414e-4c6e-b41d-56a00c988b13', [
                'ProductName' => $this->basketItem->name,
                'Price' => (float) $this->basketItem->price,
                'Timestamp' => now()->format('Y-m-d H:i:s')
            ]);

            if ($response->successful()) {
                Log::info('Order Item Completed');
            } else {
                Log::error('Subscription processing failed', [
                    'order_id' => $this->order->id,
                    'error' => $response->body()
                ]);
            }
        }catch (Exception $exception){
            Log::error('Error processing subscription', [
                'order_id' => $this->order->id,
                'error' => $exception->getMessage()
            ]);
        }
    }

}
