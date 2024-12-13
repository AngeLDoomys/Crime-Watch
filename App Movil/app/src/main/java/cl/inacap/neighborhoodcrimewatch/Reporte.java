package cl.inacap.neighborhoodcrimewatch;

import android.Manifest;
import android.annotation.SuppressLint;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.location.Location;
import android.media.MediaPlayer;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.FragmentActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.OutputStream;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;

public class Reporte extends FragmentActivity implements OnMapReadyCallback {
    EditText descripcion, ubicacion; // Campos para la descripción y ubicación del incidente
    Button btnRegistrar; // Botón para registrar el incidente
    RequestQueue datos;
    Location currentLocation;
    FusedLocationProviderClient fusedClient;
    private static final int REQUEST_CODE = 101;
    FrameLayout FragmentMap;

    @SuppressLint("MissingInflatedId")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reporte);

        // Inicializar los campos y el botón
        descripcion = findViewById(R.id.etDescripcion);
        btnRegistrar = findViewById(R.id.btnAlarma);
        FragmentMap = findViewById(R.id.FragmentMap);

        fusedClient = LocationServices.getFusedLocationProviderClient(this);
        getLocation();

        // Inicializar RequestQueue
        datos = Volley.newRequestQueue(this);

        // Configurar el botón de registro
        btnRegistrar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                registrarIncidente();
            }
        });
    }

    private void getLocation() {
        if (ActivityCompat.checkSelfPermission(
                this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED
                && ActivityCompat.checkSelfPermission(
                this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {

            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, REQUEST_CODE);
            return;
        }

        Task<Location> task = fusedClient.getLastLocation();

        task.addOnSuccessListener(new OnSuccessListener<Location>() {
            @Override
            public void onSuccess(Location location) {
                if (location != null) {
                    currentLocation = location;
                    SupportMapFragment supportMapFragment = (SupportMapFragment) getSupportFragmentManager().findFragmentById(R.id.FragmentMap);
                    assert supportMapFragment != null;
                    supportMapFragment.getMapAsync(Reporte.this);
                }
            }
        });
    }

    private void registrarIncidente() {
        String descripcionInput = descripcion.getText().toString().trim();
        String idUsuario = obtenerIdUsuario();

        if (descripcionInput.isEmpty() || currentLocation == null || idUsuario == null || idUsuario.isEmpty()) {
            Toast.makeText(Reporte.this, "Por favor, complete todos los campos y asegúrese de tener ubicación", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = "http:///registrarIncidente.php";

        JSONObject jsonBody = new JSONObject();
        try {
            jsonBody.put("descripcion", descripcionInput);
            jsonBody.put("latitud", String.valueOf(currentLocation.getLatitude()));
            jsonBody.put("longitud", String.valueOf(currentLocation.getLongitude()));
            jsonBody.put("idusuario", idUsuario);
        } catch (JSONException e) {
            e.printStackTrace();
            Toast.makeText(Reporte.this, "Error al crear el JSON", Toast.LENGTH_SHORT).show();
            return;
        }

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.POST, url, jsonBody,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            String estado = response.getString("estado");
                            if (estado.equals("1")) {
                                Toast.makeText(Reporte.this, "Reporte registrado exitosamente", Toast.LENGTH_SHORT).show();
                            } else {
                                Toast.makeText(Reporte.this, response.getString("mensaje"), Toast.LENGTH_SHORT).show();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(Reporte.this, "Error de conexión", Toast.LENGTH_SHORT).show();
                    }
                });

        datos.add(jsonObjectRequest);
    }

    private String obtenerIdUsuario() {
        SharedPreferences sharedPreferences = getSharedPreferences("usuario", MODE_PRIVATE);
        String idUsuario = sharedPreferences.getString("idusu", null);
        Log.d("Reporte", "ID de usuario: " + idUsuario); // Agregar un log para depuración
        return idUsuario; // Recuperar el ID del usuario
    }

    @Override
    public void onMapReady(@NonNull GoogleMap googleMap) {
        if (currentLocation != null) {
            LatLng latLng = new LatLng(currentLocation.getLatitude(), currentLocation.getLongitude());
            MarkerOptions markerOptions = new MarkerOptions().position(latLng).title("Mi Locacion");
            googleMap.animateCamera(CameraUpdateFactory.newLatLng(latLng));
            googleMap.animateCamera(CameraUpdateFactory.newLatLngZoom(latLng, 15));
            googleMap.addMarker(markerOptions);
        } else {
            Toast.makeText(this, "No se ha obtenido la ubicación actual", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == REQUEST_CODE){
            if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED){
                getLocation();
            }
        }

    }
}
