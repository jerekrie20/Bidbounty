<div>
    <h1 class="text-3xl font-bold text-white text-center mt-10 mb-10">Listings</h1>

    <div class="flex justify-between items-center bg-green-950 xl:w-2/3 m-auto">
        <div class="text-white p-4 font-semibold text-xl">
            <h3>Selected Lot: <span class="text-wheat-yellow">@if(!empty($singleLot)){{$singleLot->title}}@endif</span></h3>
        </div>

        <div>
            <select wire:model.live="selectedLot" name="selectedLot" id="selectedLot" class="bg-sky-blue text-black text-lg border-2 w-full p-2 rounded-lg">
                <option value="">Select Lot</option>
                @foreach($lots as $lot)
                    <option value="{{$lot->id}}">{{$lot->title}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>

        @if(!empty($items))
        <livewire:display-data :columns="$columns"  :id="$singleLot->id" columnID="lot_id"   model="Item"/>
        @endif

    </div>
</div>
