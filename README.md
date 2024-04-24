# veeder_root_tls450_fuel_level-query
Veeder Root tls-450 fuel level query 

##Useage 
```

$tsl450 = new TSL450('username', 'password', 'ip:port');
print_r($tsl450->GetTank(1));    

```
##Output 

Array
(
    [TankName] => Evo Diesel
    [TankId] => 1
    [TotalVolume] => 17960.024469057902
    [Ullage] => 27038.975530942102
    [WaterHeight] => 0
    [FuelHeight] => 1028.9852641593475
    [IsManifolded] => soapFALSE
    [IsDeliveryInProgress] => soapFALSE
    [FuelFloatLevelPercentage] => 40
    [WaterFloatLevelPercentage] => 0
    [HasWarnings] => soapFALSE
    [HasAlarms] => soapFALSE
    [IsProbeOut] => soapFALSE
    [IsStickHeightEnabled] => soapFALSE
    [StickHeight] => 1028.9852641593475
    [TotalTCVolume] => 18009.523361913343
    [WaterVolume] => 0
    [FuelTemperature] => 12.153013183118523
    [UserUllage] => 27038.975530942102
    [UserUllageEnabled] => soapFALSE
    [UserUllagePercentage] => 90
    [HasWaterFloat] => soapTRUE
    [HasDensityProbe] => soapFALSE
    [Density] => 0
    [Mass] => 0
    [HasTcDensity] => soapFALSE
    [TcDensity] => 0
    [DeliveredQuantity] => 16031.806422624877
    [ManifoldedQuantity] => 16031.806422624877
    [IsWorkingCapacityEnabled] => soapFALSE
    [WorkingCapacity] => 3.3360034638850619E+261
)