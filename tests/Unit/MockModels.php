<?php

namespace Tests\Unit;


use App\Lofm\Domain\Models\User as UserModel;
use App\Lofm\Domain\ValueObjects\User as UserValueObject;
use App\User;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\MockObject\MockObject;

trait MockModels{
    /**
     * @var Generator
     */
    private $faker;

    public function mockUserValueObject(array $data = []) :UserValueObject
    {
        return new UserValueObject(
            $this->getValue($data, 'email',  $this->faker->email),
            $this->getValue($data,'userName', $this->faker->userName),
            $this->getValue($data,'password', $this->faker->password(8,20))
        );
    }

//    protected function mockEloquentCourseRepeatPolicy(array $data = []): MockObject
//    {
////        $model = $this->createMock(EloquentCourseRepeat::class);
////
////        $model->method('getZrbcrptPidm')->willReturn($this->getValue($data, 'zrbcrpt_pidm', $this->randomPidm()));
////        $model->method('getZrbcrptInitialCrn')->willReturn($this->getValue($data, 'zrbcrpt_initial_crn', $this->faker->text(6)));
////        $model->method("getZrbcrptInitialTerm")->willReturn($this->getValue($data,"zrbcrpt_initial_term",(string)$this->randomTermCode()));
////        $model->method('getZrbcrptRepeatedCrn')->willReturn($this->getValue($data,"zrbcrpt_repeated_crn",$this->faker->text(6)));
////        $model->method("getZrbcrptRepeatedTerm")->willReturn($this->getValue($data,"zrbcrpt_repeated_term",$this->randomTermCode()));
////        $model->method("getZrbcrptApplicationDate")->willReturn($this->getValue($data,"zrbcrpt_application_date", $this->randomDate()));
////        $model->method('getZrbcrptAgree')->willReturn($this->getValue($data, 'zrbcrpt_agree', 'Agree'));
////        $model->method('getZrbcrptDateCompleted')->willReturn($this->getValue($data, 'zrbcrpt_date_completed', $this->randomDate()));
////        $model->method("getZrbcrptUser")->willReturn($this->getValue($data,"zrbcrpt_user",(string)$this->faker->text(6)));
////
////        return $model;
//    }

    protected function mockEloquentUser(array $data = []): MockObject
    {
        $model = $this->createMock(User::class);

        $model->method("getId")->willReturn($this->getValue($data,"id",$this->faker->uuid));
        $model->method("getEmail")->willReturn($this->getValue($data,"email",$this->faker->email));
        $model->method("getPassword")->willReturn($this->getValue($data,"password", Hash::make($this->faker->password)));
        $model->method("getEmailVerifiedAt")->willReturn($this->getValue($data,"email_verified_at",null));
        $model->method("getName")->willReturn($this->getValue($data,"name",$this->faker->name));
        $model->method("getCreatedAt")->willReturn($this->getValue($data,"created_at",$this->faker->date()));
        $model->method("getUpdatedAt")->willReturn($this->getValue($data,"updated_at",$this->faker->date()));

        return $model;
    }


    protected function mockEloquentUsers(int $number = 1, array $data = []): Collection
    {
        $collection = new Collection();
        for ($i = 0; $i < $number; $i++) {
            $collection->push($this->mockEloquentUser($this->getValue($data, $i, [])));
        }
        return $collection;
    }



    public function mockUserModel(array $data = []) :UserModel
    {
        return new UserModel(
            $this->getValue($data,"id", (string)$this->faker->randomDigit),
            $this->getValue($data, 'email',  $this->faker->email),
            $this->getValue($data,'password', $this->faker->password(8,20)),
            $this->getValue($data, 'email_verified_at',null),
            $this->getValue($data,'userName', $this->faker->userName),
            $this->getValue($data,'created_at', $this->randomDate()),
            $this->getValue($data, 'updated_at',$this->randomDate())
        );
    }
    private function getValue(array $data, string $key, $default)
    {
        if (array_key_exists($key, $data)) {
            return $data[$key];
        }

        return $default;
    }

    private function randomDate(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d', $this->faker->date('Y-m-d'));
    }

}
