package cl.inacap.neighborhoodcrimewatch;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

public class Home extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_home);
        obtenerNombreUsuario();
        configureNextButton();
    }

    private void configureNextButton(){
        Button btnReportar = (Button) findViewById(R.id.btnReportar);
        btnReportar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(Home.this, Reporte.class));
            }
        });
    }

    private void obtenerNombreUsuario() {
        // Obtener el ID del usuario desde las preferencias compartidas
        SharedPreferences sharedPreferences = getSharedPreferences("usuario", MODE_PRIVATE);
        String idUsuario = sharedPreferences.getString("idusu", "");

        // URL para la consulta
        String url = "http://54.173.43.72/consultanombre.php?usu=" + idUsuario;

        // Realizar la consulta
        JsonObjectRequest request = new JsonObjectRequest(Request.Method.GET, url, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            String nombre = response.getString("nombres");
                            // Mostrar el nombre del usuario en la pantalla
                            TextView tvNombreusu = findViewById(R.id.tvNombreusu);
                            tvNombreusu.setText(nombre);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                error.printStackTrace();
            }
        });

        // Agregar la consulta a la cola
        RequestQueue datos = Volley.newRequestQueue(this);
        datos.add(request);
    }
}


