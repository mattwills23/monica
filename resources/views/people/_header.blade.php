<div class="pagehead">
  <div class="{{ Auth::user()->getFluidLayout() }}">
    <div class="row">
      <div class="col-xs-12">

        @include ('partials.errors')
        @include ('partials.notification')

        <div class="people-profile-information">

          @if ($contact->has_avatar)
            <img src="{{ $contact->getAvatarURL(110) }}" width="87">
          @else
            @if (! is_null($contact->gravatar_url))
              <img src="{{ $contact->gravatar_url }}" width="87">
            @else
              @if (strlen($contact->getInitials()) == 1)
              <div class="avatar one-letter" style="background-color: {{ $contact->getAvatarColor() }};">
                {{ $contact->getInitials() }}
              </div>
              @else
              <div class="avatar" style="background-color: {{ $contact->getAvatarColor() }};">
                {{ $contact->getInitials() }}
              </div>
              @endif
            @endif
          @endif

          <h3>
            <span class="{{ htmldir() == 'ltr' ? 'mr1' : 'ml1' }}">{{ $contact->name }}</span>

            <contact-favorite hash="{{ $contact->hashID() }}" :starred="{{ json_encode($contact->is_starred) }}"></contact-favorite>

            @if ($contact->birthday_special_date_id && !($contact->is_dead))
              @if ($contact->birthdate->getAge())
                <span class="ml3 light-silver f4">(<i class="fa fa-birthday-cake mr1"></i> {{ $contact->birthdate->getAge() }})</span>
              @endif
            @elseif ($contact->is_dead)
                @if (! is_null($contact->deceasedDate))
                  <span class="ml3 light-silver f4">({{ trans('people.deceased_age') }} {{ $contact->getAgeAtDeath() }})</span>
                @endif
            @endif
          </h3>

          <ul class="horizontal profile-detail-summary">
            @if ($contact->is_dead)
              <li>
                @if (! is_null($contact->deceasedDate))
                  {{ trans('people.deceased_label_with_date', ['date' => $contact->deceasedDate->toShortString()]) }}
                @else
                  {{ trans('people.deceased_label') }}
                @endif
              </li>
            @endif
            <li>
              {{ $contact->description }}
            </li>
          </ul>

          <stay-in-touch :contact="{{ $contact }}" hash="{{ $contact->hashID() }}" limited="{{ auth()->user()->account->hasLimitations() }}"></stay-in-touch>

          <tags hash="{{ $contact->hashID() }}"></tags>

          <ul class="horizontal quick-actions">
            <li>
              <a href="{{ route('people.edit', $contact) }}" class="btn edit-information" id="button-edit-contact">{{ trans('people.edit_contact_information') }}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
